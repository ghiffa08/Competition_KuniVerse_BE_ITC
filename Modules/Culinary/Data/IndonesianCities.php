<?php

namespace Modules\Culinary\Data;

class IndonesianCities
{
    /**
     * Get list of major Indonesian cities for fallback
     * This is a subset - ideally you'd have a complete database
     */
    public static function getCities()
    {
        return [
            // Jakarta
            ['id' => 151, 'city_name' => 'Jakarta Barat', 'type' => 'Kota', 'province' => 'DKI Jakarta'],
            ['id' => 152, 'city_name' => 'Jakarta Pusat', 'type' => 'Kota', 'province' => 'DKI Jakarta'],
            ['id' => 153, 'city_name' => 'Jakarta Selatan', 'type' => 'Kota', 'province' => 'DKI Jakarta'],
            ['id' => 154, 'city_name' => 'Jakarta Timur', 'type' => 'Kota', 'province' => 'DKI Jakarta'],
            ['id' => 155, 'city_name' => 'Jakarta Utara', 'type' => 'Kota', 'province' => 'DKI Jakarta'],
            
            // Jawa Barat
            ['id' => 22, 'city_name' => 'Bandung', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 23, 'city_name' => 'Bandung', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 24, 'city_name' => 'Bandung Barat', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 25, 'city_name' => 'Banjar', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 26, 'city_name' => 'Bekasi', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 27, 'city_name' => 'Bekasi', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 28, 'city_name' => 'Bogor', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 29, 'city_name' => 'Bogor', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 78, 'city_name' => 'Cirebon', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 79, 'city_name' => 'Cirebon', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 80, 'city_name' => 'Ciamis', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 81, 'city_name' => 'Cianjur', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 82, 'city_name' => 'Cimahi', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 114, 'city_name' => 'Depok', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 160, 'city_name' => 'Garut', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 182, 'city_name' => 'Indramayu', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 197, 'city_name' => 'Karawang', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 211, 'city_name' => 'Kuningan', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 241, 'city_name' => 'Majalengka', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 370, 'city_name' => 'Sukabumi', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 371, 'city_name' => 'Sukabumi', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 378, 'city_name' => 'Sumedang', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            ['id' => 398, 'city_name' => 'Tasikmalaya', 'type' => 'Kota', 'province' => 'Jawa Barat'],
            ['id' => 399, 'city_name' => 'Tasikmalaya', 'type' => 'Kabupaten', 'province' => 'Jawa Barat'],
            
            // Jawa Tengah
            ['id' => 444, 'city_name' => 'Semarang', 'type' => 'Kota', 'province' => 'Jawa Tengah'],
            ['id' => 445, 'city_name' => 'Semarang', 'type' => 'Kabupaten', 'province' => 'Jawa Tengah'],
            ['id' => 101, 'city_name' => 'Solo (Surakarta)', 'type' => 'Kota', 'province' => 'Jawa Tengah'],
            
            // Jawa Timur
            ['id' => 444, 'city_name' => 'Surabaya', 'type' => 'Kota', 'province' => 'Jawa Timur'],
            ['id' => 255, 'city_name' => 'Malang', 'type' => 'Kota', 'province' => 'Jawa Timur'],
            ['id' => 256, 'city_name' => 'Malang', 'type' => 'Kabupaten', 'province' => 'Jawa Timur'],
            
            // Bali
            ['id' => 114, 'city_name' => 'Denpasar', 'type' => 'Kota', 'province' => 'Bali'],
            ['id' => 17, 'city_name' => 'Badung', 'type' => 'Kabupaten', 'province' => 'Bali'],
            
            // Sumatra
            ['id' => 249, 'city_name' => 'Medan', 'type' => 'Kota', 'province' => 'Sumatera Utara'],
            ['id' => 340, 'city_name' => 'Palembang', 'type' => 'Kota', 'province' => 'Sumatera Selatan'],
        ];
    }
    
    /**
     * Search cities by keyword
     */
    public static function search($keyword)
    {
        $keyword = strtolower(trim($keyword));
        $cities = self::getCities();
        
        return array_filter($cities, function($city) use ($keyword) {
            $cityName = strtolower($city['city_name']);
            $province = strtolower($city['province']);
            
            return strpos($cityName, $keyword) !== false || 
                   strpos($province, $keyword) !== false;
        });
    }
    
    /**
     * Get mock shipping costs for testing/fallback
     * Returns basic shipping options with estimated prices
     */
    public static function getMockShippingCosts($originId, $destinationId, $weight)
    {
        // Base price calculation: Rp 1000 per 100 gram + base rate
        $basePrice = 10000; // Rp 10.000 base
        $weightPrice = ($weight / 100) * 1000; // Rp 1000 per 100g
        
        return [
            [
                'code' => 'jne',
                'name' => 'JNE',
                'costs' => [
                    [
                        'service' => 'REG',
                        'cost' => [
                            ['value' => intval($basePrice + $weightPrice), 'etd' => '2-3']
                        ]
                    ],
                    [
                        'service' => 'YES',
                        'cost' => [
                            ['value' => intval($basePrice + $weightPrice + 5000), 'etd' => '1-1']
                        ]
                    ]
                ]
            ],
            [
                'code' => 'pos',
                'name' => 'POS Indonesia',
                'costs' => [
                    [
                        'service' => 'Paket Kilat Khusus',
                        'cost' => [
                            ['value' => intval($basePrice + $weightPrice - 2000), 'etd' => '3-4']
                        ]
                    ]
                ]
            ],
            [
                'code' => 'tiki',
                'name' => 'TIKI',
                'costs' => [
                    [
                        'service' => 'REG',
                        'cost' => [
                            ['value' => intval($basePrice + $weightPrice + 1000), 'etd' => '2-3']
                        ]
                    ]
                ]
            ]
        ];
    }
}
