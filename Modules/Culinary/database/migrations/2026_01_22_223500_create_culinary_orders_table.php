<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('culinary_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('culinary_id')->constrained('culinaries')->onDelete('cascade');
            
            $table->string('invoice_number')->unique();
            
            // Customer Info
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            
            // Delivery Info
            $table->text('delivery_address');
            $table->decimal('delivery_latitude', 10, 8)->nullable();
            $table->decimal('delivery_longitude', 11, 8)->nullable();
            
            // Courier Info
            $table->string('courier_name')->nullable(); // e.g., Gojek
            $table->string('courier_service')->nullable(); // e.g., Instant
            $table->string('courier_description')->nullable(); 
            $table->string('biteship_order_id')->nullable();
            $table->string('biteship_tracking_id')->nullable();
            
            // Payment Info
            $table->decimal('total_price', 15, 2)->default(0); // Items total
            $table->decimal('delivery_fee', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->string('snap_token')->nullable();
            $table->string('payment_status')->default('pending'); // pending, paid, expire, cancel
            $table->string('order_status')->default('pending'); // pending, processing, shipping, completed, cancelled
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('culinary_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('culinary_order_id')->constrained('culinary_orders')->onDelete('cascade');
            $table->foreignId('culinary_menu_id')->nullable()->constrained('culinary_menus')->nullOnDelete();
            
            $table->string('name'); // Snapshot of menu name
            $table->decimal('price', 15, 2); // Snapshot of price
            $table->integer('qty');
            $table->decimal('subtotal', 15, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('culinary_order_items');
        Schema::dropIfExists('culinary_orders');
    }
};
