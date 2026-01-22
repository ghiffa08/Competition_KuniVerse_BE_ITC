<?php

namespace Modules\Culinary\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Culinary\Models\Culinary;
use Illuminate\Support\Str;

class CulinaryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Culinaries Seed
         * ------------------
         */

        DB::table('culinary_menus')->truncate();
        echo "Truncate: culinary_menus \n";

        DB::table('culinaries')->truncate();
        echo "Truncate: culinaries \n";

        $culinaries = [
            [
                'name' => 'Hutan Kota by Plataran Kuningan',
                'location' => 'Cigugur, Kuningan',
                'rating' => 4.8,
                'category' => 'Cafe & Resto',
                'image' => 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Menikmati suasana hutan kota yang asri dengan hidangan modern dan tradisional yang lezat.',
                'latitude' => -6.966667,
                'longitude' => 108.466667,
            ],
            [
                'name' => 'Saung Liwet Bu Tini',
                'location' => 'Cilimus, Kuningan',
                'rating' => 4.7,
                'category' => 'Sunda',
                'image' => 'https://images.pexels.com/photos/5410418/pexels-photo-5410418.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Nasi liwet khas Sunda dengan lauk pauk komplit, cocok untuk makan bersama keluarga.',
                'latitude' => -6.890000,
                'longitude' => 108.500000,
            ],
            [
                'name' => 'Rumah Makan Ampera Kuningan',
                'location' => 'Kuningan Kota',
                'rating' => 4.6,
                'category' => 'Sunda',
                'image' => 'https://images.pexels.com/photos/1111317/pexels-photo-1111317.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Masakan Sunda prasmanan dengan berbagai pilihan menu yang menggugah selera.',
                'latitude' => -6.980000,
                'longitude' => 108.480000,
            ],
            [
                'name' => 'Saung Lesehan Cibulan',
                'location' => 'Maniskidul, Jalaksana',
                'rating' => 4.7,
                'category' => 'Sunda',
                'image' => 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Tempat makan lesehan di tepi kolam ikan dengan suasana pedesaan yang menenangkan.',
                'latitude' => -6.900000,
                'longitude' => 108.490000,
            ],
            [
                'name' => 'Warung Nasi Kasreng',
                'location' => 'Cigugur, Kuningan',
                'rating' => 4.5,
                'category' => 'Tradisional',
                'image' => 'https://images.pexels.com/photos/461198/pexels-photo-461198.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Nikmati nasi kasreng yang legendaris dengan harga terjangkau dan rasa otentik.',
                'latitude' => -6.975000,
                'longitude' => 108.470000,
            ],
            [
                'name' => 'Saung Apung Darma',
                'location' => 'Darma, Kuningan',
                'rating' => 4.8,
                'category' => 'Sunda',
                'image' => 'https://images.pexels.com/photos/1893556/pexels-photo-1893556.jpeg?auto=compress&cs=tinysrgb&w=800',
                'description' => 'Sensasi makan di atas air dengan pemandangan Waduk Darma yang mempesona.',
                'latitude' => -7.010000,
                'longitude' => 108.400000,
            ],
        ];

        $sample_menus = [
            // Makanan
            ['name' => 'Nasi Liwet Sunda', 'category' => 'makanan', 'price' => 25000, 'image' => 'https://images.pexels.com/photos/699953/pexels-photo-699953.jpeg', 'description' => 'Nasi liwet wangi dengan ikan asin dan lalapan.'],
            ['name' => 'Ayam Bakar', 'category' => 'makanan', 'price' => 30000, 'image' => 'https://images.pexels.com/photos/410648/pexels-photo-410648.jpeg', 'description' => 'Ayam bakar dengan bumbu kecap manis pedas.'],
            ['name' => 'Karedok', 'category' => 'makanan', 'price' => 15000, 'image' => 'https://images.pexels.com/photos/3026804/pexels-photo-3026804.jpeg', 'description' => 'Sayuran mentah segar dengan bumbu kacang khas.'],
            ['name' => 'Gurame Terbang', 'category' => 'makanan', 'price' => 85000, 'image' => 'https://images.pexels.com/photos/262959/pexels-photo-262959.jpeg', 'description' => 'Ikan gurame goreng kering yang renyah.'],
            
            // Minuman
            ['name' => 'Es Teh Manis', 'category' => 'minuman', 'price' => 5000, 'image' => 'https://images.pexels.com/photos/616836/pexels-photo-616836.jpeg', 'description' => 'Teh manis segar dingin.'],
            ['name' => 'Es Jeruk', 'category' => 'minuman', 'price' => 10000, 'image' => 'https://images.pexels.com/photos/96974/pexels-photo-96974.jpeg', 'description' => 'Jeruk peras murni dengan es batu.'],
            ['name' => 'Kopi Tubruk', 'category' => 'minuman', 'price' => 12000, 'image' => 'https://images.pexels.com/photos/302899/pexels-photo-302899.jpeg', 'description' => 'Kopi hitam panas tradisional.'],
            
            // Cemilan
            ['name' => 'Pisang Goreng', 'category' => 'cemilan', 'price' => 15000, 'image' => 'https://images.pexels.com/photos/461428/pexels-photo-461428.jpeg', 'description' => 'Pisang goreng manis dan renyah.'],
            ['name' => 'Tahu Gejrot', 'category' => 'cemilan', 'price' => 10000, 'image' => 'https://images.pexels.com/photos/725997/pexels-photo-725997.jpeg', 'description' => 'Tahu goreng dengan kuah asam pedas.'],
            ['name' => 'Cireng Rujak', 'category' => 'cemilan', 'price' => 12000, 'image' => 'https://images.pexels.com/photos/566566/pexels-photo-566566.jpeg', 'description' => 'Cireng kenyal dengan bumbu rujak.'],
        ];

        foreach ($culinaries as $data) {
            $culinary = Culinary::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'location' => $data['location'],
                'rating' => $data['rating'],
                'category' => $data['category'],
                'image' => $data['image'],
                'description' => $data['description'],
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'status' => 1,
                'note' => 'Dummy Data',
            ]);

            // Seed Menus for this Culinary
            foreach ($sample_menus as $menu) {
                // Randomly skip some menus to vary the data slightly per restaurant
                if (rand(0, 10) > 8) continue;

                $culinary->menus()->create([
                    'name' => $menu['name'],
                    'category' => $menu['category'],
                    'price' => $menu['price'],
                    'image' => $menu['image'],
                    'description' => $menu['description'],
                    'sort_order' => rand(1, 10),
                    'is_available' => true,
                ]);
            }
        }

        echo " Insert: culinaries and menus (Dummy Sunda Data) \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
