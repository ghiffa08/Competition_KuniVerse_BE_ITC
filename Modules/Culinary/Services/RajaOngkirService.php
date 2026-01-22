<?php

namespace Modules\Culinary\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $baseUrl;
    protected $originType;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key', env('RAJAONGKIR_API_KEY'));
        // Komerce API - use sandbox for testing, production when live
        $this->baseUrl = config('services.rajaongkir.base_url', 'https://api-sandbox.collaborator.komerce.id'); 
        $this->originType = config('services.rajaongkir.origin_type', 'city');
    }

    public function getProvinces()
    {
        return $this->request('province');
    }

    public function searchDestination($query)
    {
        // Komerce API endpoint for searching destination
        return $this->komerceRequest('tariff/api/v1/destination', ['search' => $query]);
    }

    public function getCities($provinceId = null)
    {
        $params = [];
        if ($provinceId) {
            $params['province'] = $provinceId;
        }
        return $this->request('city', $params);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        // Komerce API calculate endpoint
        $params = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight, // in grams
            'courier' => $courier // jne, pos, tiki, jnt, sicepat, etc
        ];

        return $this->komerceRequest('tariff/api/v1/calculate', $params);
    }

    protected function request($endpoint, $params = [])
    {
        try {
            \Log::info("RajaOngkir GET $endpoint", ['params' => $params, 'key_exists' => !empty($this->apiKey), 'url' => $this->baseUrl]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json'
            ])->get($this->baseUrl . '/' . $endpoint, $params);

            \Log::info("RajaOngkir Response Status: " . $response->status());
            
            if ($response->successful()) {
                $body = $response->json();
                \Log::info("RajaOngkir Response Body Sample", ['keys' => array_keys($body)]);
                return $body['rajaongkir']['results'] ?? $body['data'] ?? [];
            }
            
            \Log::error("RajaOngkir GET Error: " . $response->body());
            return [];
        } catch (\Exception $e) {
            \Log::error("RajaOngkir GET Exception: " . $e->getMessage());
            return [];
        }
    }

    protected function postRequest($endpoint, $data = [])
    {
        try {
            \Log::info("RajaOngkir POST $endpoint", ['data' => $data]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/' . $endpoint, $data);

            if ($response->successful()) {
                $body = $response->json();
                return $body['rajaongkir']['results'] ?? $body['data'] ?? [];
            }
            
            \Log::error("RajaOngkir POST Error: " . $response->body());
            return ['error' => $response->body()];
        } catch (\Exception $e) {
            \Log::error("RajaOngkir POST Exception: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    protected function komerceRequest($endpoint, $params = [])
    {
        try {
            \Log::info("Komerce GET $endpoint", ['params' => $params, 'key_exists' => !empty($this->apiKey)]);
            
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json'
            ])->get($this->baseUrl . '/' . $endpoint, $params);

            \Log::info("Komerce Response", [
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            
            if ($response->successful()) {
                $body = $response->json();
                // Komerce returns data directly in various formats
                return $body['data'] ?? $body['results'] ?? $body;
            }
            
            \Log::error("Komerce GET Error: " . $response->body());
            return [];
        } catch (\Exception $e) {
            \Log::error("Komerce GET Exception: " . $e->getMessage());
            return [];
        }
    }
}
