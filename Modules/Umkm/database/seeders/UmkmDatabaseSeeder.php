<?php

namespace Modules\Umkm\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Umkm\Models\Umkm;

class UmkmDatabaseSeeder extends Seeder
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
         * Umkms Seed
         * ------------------
         */

        // DB::table('umkms')->truncate();
        // echo "Truncate: umkms \n";

        Umkm::factory()->count(20)->create();
        $rows = Umkm::all();
        echo " Insert: umkms \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
