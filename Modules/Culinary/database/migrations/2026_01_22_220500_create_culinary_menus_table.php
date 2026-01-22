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
        Schema::create('culinary_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('culinary_id')->constrained('culinaries')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->string('category')->default('makanan'); // makanan, minuman, cemilan
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('culinary_menus');
    }
};
