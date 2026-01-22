<?php

namespace Modules\Tourism\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Tourism\Models\Tourism;

class TourismDatabaseSeeder extends Seeder
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
         * Tourisms Seed
         * ------------------
         */

        DB::table('tourisms')->truncate();

        $destinations = [
            [
                'name' => 'Telaga Biru Cicerem',
                'address' => 'Kaduela, Pasawahan',
                'intro' => 'Nikmati keindahan Telaga Biru Cicerem yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/2444403/pexels-photo-2444403.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 15000,
                'rating' => 4.8,
                'latitude' => '-6.7825',
                'longitude' => '108.4230',
            ],
            [
                'name' => 'Waduk Darma',
                'address' => 'Darma, Kuningan',
                'intro' => 'Nikmati keindahan Waduk Darma yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/2132126/pexels-photo-2132126.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 20000,
                'rating' => 4.7,
                'latitude' => '-7.0065',
                'longitude' => '108.4056',
            ],
            [
                'name' => 'Gedung Linggarjati',
                'address' => 'Linggarjati, Cilimus',
                'intro' => 'Nikmati keindahan Gedung Linggarjati yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/534228/pexels-photo-534228.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 10000,
                'rating' => 4.9,
                'latitude' => '-6.8778',
                'longitude' => '108.4797',
            ],
            [
                'name' => 'Curug Putri',
                'address' => 'Cisantana, Cigugur',
                'intro' => 'Nikmati keindahan Curug Putri yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/358457/pexels-photo-358457.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 25000,
                'rating' => 4.6,
                'latitude' => '-6.9606',
                'longitude' => '108.4353',
            ],
            [
                'name' => 'Sukageuri View',
                'address' => 'Cisantana, Cigugur',
                'intro' => 'Nikmati keindahan Sukageuri View yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/1666021/pexels-photo-1666021.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 15000,
                'rating' => 4.7,
                'latitude' => '-6.9536',
                'longitude' => '108.4394',
            ],
            [
                'name' => 'Woodland',
                'address' => 'Setianegara, Cilimus',
                'intro' => 'Nikmati keindahan Woodland yang memukau di Kuningan.',
                'image' => 'https://images.pexels.com/photos/1671325/pexels-photo-1671325.jpeg?auto=compress&cs=tinysrgb&w=800',
                'price' => 30000,
                'rating' => 4.5,
                'latitude' => '-6.8458',
                'longitude' => '108.4719',
            ],
        ];

        foreach ($destinations as $dest) {
            Tourism::create([
                'name' => $dest['name'],
                'slug' => Str::slug($dest['name']),
                'intro' => $dest['intro'],
                'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>',
                'image' => $dest['image'],
                'images' => [$dest['image']],
                'address' => $dest['address'],
                'type' => 'Nature',
                'price' => $dest['price'],
                'rating' => $dest['rating'],
                'status' => 1,
                'facilities' => "Parkir Luas\nMusholla\nToilet Bersih\nWarung Makan\nSpot Foto",
                'latitude' => $dest['latitude'],
                'longitude' => $dest['longitude'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $rows = Tourism::all();
        echo ' Insert: tourisms ('.$rows->count()." rows)\n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
