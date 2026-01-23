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
        Schema::create('umkm_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkm_id');
            $table->unsignedBigInteger('user_id')->nullable();
            
            // Order Info
            $table->string('order_id')->unique(); // For payment gateway (e.g., UMKM-DATE-RAND)
            $table->string('status')->default('pending'); // pending, paid, processing, completed, cancelled
            
             // Customer Info
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email');
            
            // Shipping Info
            $table->string('shipping_address');
            $table->string('shipping_courier'); // jne, pos, etc.
            $table->string('shipping_service'); // REG, YES, etc.
            $table->integer('shipping_cost')->default(0);
            
            // Payment Info
            $table->integer('subtotal');
            $table->integer('total_amount');
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->text('snap_token')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_orders');
    }
};
