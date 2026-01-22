<?php

namespace Modules\Culinary\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Culinary\Models\Culinary;
use Modules\Culinary\Models\CulinaryOrder;
use Modules\Culinary\Models\CulinaryOrderItem;
use Modules\Culinary\Services\RajaOngkirService;
use Modules\Culinary\Data\IndonesianCities;
use Modules\Booking\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CulinaryCheckoutController extends Controller
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
        $culinary = Culinary::findOrFail($id);
        return view('culinary::frontend.culinaries.checkout', compact('culinary'));
    }

    public function searchDestination(Request $request)
    {
        $term = strtolower($request->term);
        \Log::info("Searching destination with term: $term");
        
        if(strlen($term) < 3) return response()->json([]);

        // Try Komerce API first
        $cities = $this->rajaOngkir->searchDestination($term); 
        
        // Fallback to local data if API fails
        if (empty($cities)) {
            \Log::warning("Komerce API failed, using local fallback data");
            $localCities = IndonesianCities::search($term);
            $cities = array_values($localCities); // Re-index array
        }
        
        if (empty($cities)) {
            \Log::info("No cities found for term: $term");
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
        
        \Log::info("Search results count: " . count($results));

        return response()->json($results);
    }

    public function checkShipping(Request $request)
    {
        $request->validate([
            'destination_id' => 'required',
            'weight' => 'required',
        ]);
        
        // Default origin city ID (example: Jakarta Pusat = 152, Jakarta Selatan = 153)
        // You should configure this in your .env
        $originVal = config('services.rajaongkir.default_origin', 153); 

        // Convert kg to grams (RajaOngkir expects weight in grams)
        $weightInGrams = $request->weight * 1000;
        
        Log::info('CheckShipping Request', [
            'origin' => $originVal,
            'destination' => $request->destination_id,
            'weight_kg' => $request->weight,
            'weight_grams' => $weightInGrams
        ]);

        // RajaOngkir Starter supports: jne, pos, tiki
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
            } else {
                 Log::warning("RajaOngkir Cost Check Failed for $courier", ['result' => $results]);
            }
        }
        
        // Fallback to mock data if no results from API
        if (empty($allCosts)) {
            Log::warning("No shipping costs from API, using mock data");
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
        
        Log::info('CheckShipping Response', [
            'total_costs' => count($allCosts),
            'costs' => $allCosts
        ]);

        return response()->json(['data' => $allCosts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'culinary_id' => 'required|exists:culinaries,id',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'customer_email' => 'required|email',
            'delivery_address' => 'required|string',
            'delivery_cost' => 'required|numeric',
            'total_price' => 'required|numeric',
            'items' => 'required|array',
            'courier_name' => 'required|string',
            'courier_service' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $culinary = Culinary::findOrFail($request->culinary_id);
            $grandTotal = $request->total_price + $request->delivery_cost;
            $invoice = 'INV/CUL/' . date('Ymd') . '/' . rand(1000, 9999);

            $order = CulinaryOrder::create([
                'user_id' => auth()->id(), // null if guest
                'culinary_id' => $culinary->id,
                'invoice_number' => $invoice,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'delivery_latitude' => null, 
                'delivery_longitude' => null,
                'courier_name' => $request->courier_name,
                'courier_service' => $request->courier_service,
                'courier_description' => $request->courier_desc,
                'total_price' => $request->total_price,
                'delivery_fee' => $request->delivery_cost,
                'grand_total' => $grandTotal,
                'payment_status' => 'pending',
                'order_status' => 'pending'
            ]);

            foreach ($request->items as $item) {
                CulinaryOrderItem::create([
                    'culinary_order_id' => $order->id,
                    'culinary_menu_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty']
                ]);
            }

            // Generate Midtrans Token
            $params = [
                'transaction_details' => [
                    'order_id' => $order->invoice_number,
                    'gross_amount' => (int) $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                    'email' => $request->customer_email ?? 'customer@example.com',
                ],
            ];

            $snapToken = $this->midtrans->getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'snap_token' => $snapToken,
                'redirect_url' => route('frontend.culinaries.index') // Or success page
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
