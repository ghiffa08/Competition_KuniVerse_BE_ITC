<?php

namespace Modules\UMKM\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\UMKM\Models\UMKM;
use Modules\UMKM\Models\UMKMOrder;
use Modules\UMKM\Models\UMKMOrderItem;
use Modules\UMKM\Services\RajaOngkirService;
use Modules\UMKM\Data\IndonesianCities;
use Modules\Booking\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class UMKMCheckoutController extends Controller
{
    protected $rajaOngkir;
    protected $midtrans;

    public function __construct(RajaOngkirService $rajaOngkir, MidtransService $midtrans)
    {
        $this->rajaOngkir = $rajaOngkir;
        $this->midtrans = $midtrans;
    }

    public function checkout($id)
    {
        $umkm = UMKM::findOrFail($id);
        return view('umkm::frontend.umkms.checkout', compact('umkm'));
    }

    public function searchDestination(Request $request)
    {
        $term = strtolower($request->term);
        
        if(strlen($term) < 3) return response()->json([]);

        // Try Komerce API first
        $cities = $this->rajaOngkir->searchDestination($term); 
        
        // Fallback to local data if API fails
        if (empty($cities)) {
            $localCities = IndonesianCities::search($term);
            $cities = array_values($localCities); // Re-index array
        }
        
        if (empty($cities)) {
            return response()->json([]);
        }

        // Transform to our format
        $results = [];
        foreach($cities as $city) {
            $results[] = [
                'id' => $city['id'] ?? $city['city_id'],
                'display_name' => $city['name'] ?? $city['display_name'] ?? ($city['type'] . ' ' . $city['city_name'] . ', ' . $city['province']),
                'type' => $city['type'] ?? '',
                'city_name' => $city['city_name'] ?? $city['name'],
                'province_name' => $city['province'] ?? '',
            ];
        }
        
        // Limit results
        $results = array_slice($results, 0, 20);
        
        return response()->json($results);
    }

    public function checkShipping(Request $request)
    {
        $request->validate([
            'destination_id' => 'required',
            'weight' => 'required',
        ]);
        
        $originVal = config('services.rajaongkir.default_origin', 153); 
        $weightInGrams = $request->weight * 1000;
        
        $couriers = ['jne', 'pos', 'tiki']; 
        $allCosts = []; 

        foreach($couriers as $courier) {
            $results = $this->rajaOngkir->getCost(
                $originVal,
                $request->destination_id,
                $weightInGrams,
                $courier
            );

            if (!empty($results) && !isset($results['error'])) {
                foreach($results as $result) {
                    if(!isset($result['code'])) continue;
                    $code = $result['code'];
                    $name = $result['name'];
                    if(!empty($result['costs'])) {
                        foreach($result['costs'] as $cost) {
                            $allCosts[] = [
                                'code' => $code, // jne
                                'service' => $cost['service'], // REG
                                'price' => $cost['cost'][0]['value'],
                                'etd' => $cost['cost'][0]['etd'],
                                'shipper_name' => $name
                            ];
                        }
                    }
                }
            }
        }
        
        // Fallback Mock
        if (empty($allCosts)) {
            $mockResults = IndonesianCities::getMockShippingCosts($originVal, $request->destination_id, $weightInGrams);
            foreach($mockResults as $result) {
                $code = $result['code'];
                $name = $result['name'];
                if(!empty($result['costs'])) {
                    foreach($result['costs'] as $cost) {
                        $allCosts[] = [
                            'code' => $code,
                            'service' => $cost['service'],
                            'price' => $cost['cost'][0]['value'],
                            'etd' => $cost['cost'][0]['etd'],
                            'shipper_name' => $name
                        ];
                    }
                }
            }
        }
        
        return response()->json($allCosts); 
    }

    public function store(Request $request)
    {
        $rules = [
            'umkm_id' => 'required|exists:umkms,id',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'cart' => 'required|array',
            'mode' => 'nullable|string',
        ];

        if ($request->mode === 'delivery') {
            $rules['address'] = 'required|string';
            $rules['destination_id'] = 'required';
            $rules['courier'] = 'required';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $umkm = UMKM::findOrFail($request->umkm_id);
            
            // Calculate Totals
            $subtotal = 0;
            foreach ($request->cart as $item) {
                $subtotal += ($item['price'] * $item['qty']);
            }
            
            $deliveryFee = 0;
            $shippingCouier = null;
            $shippingService = null;
            
            if ($request->mode === 'delivery' && $request->courier) {
                $deliveryFee = $request->courier['price'];
                $shippingCouier = $request->courier['code'];
                $shippingService = $request->courier['service'];
            }
            
            $grandTotal = (int) ($subtotal + $deliveryFee);
            $invoice = 'INV/UMKM/' . date('Ymd') . '/' . rand(1000, 9999);

            $order = UMKMOrder::create([
                'user_id' => auth()->id(),
                'umkm_id' => $umkm->id,
                'order_id' => $invoice,
                'status' => 'pending',
                'customer_name' => $request->name,
                'customer_phone' => $request->phone,
                'customer_email' => $request->email,
                'shipping_address' => $request->address ?? '-',
                'shipping_courier' => $shippingCouier ?? 'pickup',
                'shipping_service' => $shippingService ?? '-',
                'shipping_cost' => $deliveryFee,
                'subtotal' => $subtotal,
                'total_amount' => $grandTotal,
                'payment_status' => 'unpaid',
            ]);

            foreach ($request->cart as $item) {
                UMKMOrderItem::create([
                    'order_id' => $order->id,
                    'item_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty']
                ]);
            }

            // Generate Midtrans Token
            // Use config if needed for is3ds, etc.
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_id, // Use string ID
                    'gross_amount' => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ],
            ];

            $snapToken = $this->midtrans->getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('UMKM Order Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function reverseGeocode(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        
        try {
            // Proxy request to Nominatim
            $response = Http::withHeaders([
                'User-Agent' => config('app.name') . '/1.0 (' . config('app.url') . ')'
            ])->get("https://nominatim.openstreetmap.org/reverse", [
                'format' => 'json',
                'lat' => $lat,
                'lon' => $lng
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
