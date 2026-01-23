<?php

namespace Modules\UMKM\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\UMKM\Models\UMKM;

class UMKMDatabaseSeeder extends Seeder
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
         * UMKMS Seed
         * ------------------
         */

        // DB::table('umkms')->truncate();
        // echo "Truncate: umkms \n";

        UMKM::factory()->count(20)->create();
        $rows = UMKM::all();
        echo " Insert: umkms \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
