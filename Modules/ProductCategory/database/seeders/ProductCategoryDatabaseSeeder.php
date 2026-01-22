<?php

namespace Modules\ProductCategory\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ProductCategory\Models\ProductCategory;

class ProductCategoryDatabaseSeeder extends Seeder
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
         * ProductCategories Seed
         * ------------------
         */

        // DB::table('productcategories')->truncate();
        // echo "Truncate: productcategories \n";

        ProductCategory::factory()->count(20)->create();
        $rows = ProductCategory::all();
        echo " Insert: productcategories \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
