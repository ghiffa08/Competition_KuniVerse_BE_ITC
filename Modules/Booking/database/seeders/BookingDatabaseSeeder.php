<?php

namespace Modules\Booking\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Booking\Models\Booking;

class BookingDatabaseSeeder extends Seeder
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
         * Bookings Seed
         * ------------------
         */

        // DB::table('bookings')->truncate();
        // echo "Truncate: bookings \n";

        Booking::factory()->count(20)->create();
        $rows = Booking::all();
        echo " Insert: bookings \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
