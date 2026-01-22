<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('culinary_orders', function (Blueprint $table) {
            $table->string('type')->default('delivery')->after('invoice_number'); // delivery, dine_in
            $table->date('booking_date')->nullable()->after('type');
            $table->integer('people_count')->nullable()->after('booking_date');
            
            // Make delivery address nullable for dine_in orders
            $table->text('delivery_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('culinary_orders', function (Blueprint $table) {
            $table->dropColumn(['type', 'booking_date', 'people_count']);
            $table->text('delivery_address')->nullable(false)->change();
        });
    }
};
