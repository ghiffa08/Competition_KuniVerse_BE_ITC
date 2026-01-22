<?php

namespace Modules\Culinary\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.biteship.key');
        $this->baseUrl = 'https://api.biteship.com/v1';
    }

    public function getRates($originLat, $originLng, $destinationLat, $destinationLng, $items)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/rates/couriers', [
                'origin_latitude' => $originLat,
                'origin_longitude' => $originLng,
                'destination_latitude' => $destinationLat,
                'destination_longitude' => $destinationLng,
                'couriers' => 'gojek,grab,jne,sicepat,jnt', // Filter popular couriers
                'items' => $items, // Array of items: [{name, description, value, length, width, height, weight, quantity}]
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return ['success' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function createOrder($orderData)
    {
        try {
             $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/orders', $orderData);
            
            if ($response->successful()) {
                return $response->json();
            }

            return ['success' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
             return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
