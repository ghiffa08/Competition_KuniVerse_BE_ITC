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
        Schema::create('umkm_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            // Assuming we allow direct items or stored items. For now let's store snapshot.
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('subtotal');
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('umkm_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_order_items');
    }
};
