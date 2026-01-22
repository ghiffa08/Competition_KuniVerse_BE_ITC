<?php

namespace Modules\Culinary\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KomerceService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.komerce.key', env('KOMERCE_API_KEY'));
        $this->baseUrl = 'https://rajaongkir.komerce.id/api/v1'; 
    }

    public function searchDestination($query)
    {
        // Docs: destination/domestic-destination (GET)
        return $this->request('destination/domestic-destination', ['search' => $query]);
    }

    public function calculate($originId, $destinationId, $weight, $courier = 'jne')
    {
        // Docs: calculate/district/domestic-cost (POST)
        // Check cost between two districts
        // Couriers can be colon separated: jne:sicepat:jnt
        
        $params = [
            'origin' => $originId, 
            'destination' => $destinationId,
            'weight' => $weight, 
            'courier' => $courier 
        ];

        return $this->request('calculate/district/domestic-cost', $params, 'post');
    }

    protected function request($endpoint, $params = [], $method = 'get')
    {
        try {
            Log::info("Komerce Request to $endpoint", ['params' => $params, 'key' => substr($this->apiKey, 0, 5) . '...']);

            $http = Http::withHeaders([
                'key' => $this->apiKey, // RajaOngkir usually uses 'key'
                'X-API-KEY' => $this->apiKey // Keeping both to be safe as Komerce might use this
            ]);

            if ($method === 'post') {
                $response = $http->asForm()->post($this->baseUrl . '/' . $endpoint, $params);
            } else {
                $response = $http->get($this->baseUrl . '/' . $endpoint, $params);
            }

            Log::info("Komerce Response from $endpoint", ['status' => $response->status(), 'body' => $response->json()]);

            if ($response->successful()) {
                 return $response->json();
            }
            
            Log::error('Komerce Error: ' . $response->body());
            return ['status' => false, 'message' => $response->body()];
        } catch (\Exception $e) {
            Log::error('Komerce Exception: ' . $e->getMessage());
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
