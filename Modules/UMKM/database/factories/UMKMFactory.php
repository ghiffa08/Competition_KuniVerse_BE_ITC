<?php

namespace Modules\UMKM\database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\UMKM\Models\UMKM>
 */
class UMKMFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\UMKM\Models\UMKM::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $names = [
            'Tape Ketan Ember Bu Mumun', 'Kecimpring Renyah Kuningan', 'Jeniser Sirup Jeruk Nipis', 
            'Galeri Batik Kuningan', 'Kopi Liberika Cibeureum', 'Opak Bakar Linggarjati', 
            'Emping Melinjo Menes', 'Minuman Segar Bojot', 'Rengginang Lor', 'Ubi Cilembu Oven',
            'Keripik Pisang Sale', 'Dodol Susu Sapi', 'Yoghurt Lembang Cabang Kuningan', 'Tahu Susu Kuningan'
        ];
        
        $name = $this->faker->randomElement($names) . ' ' . $this->faker->suffix;

        return [
            'name'              => $name,
            'slug'              => Str::slug($name),
            'note'              => $this->faker->paragraph(10),
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
