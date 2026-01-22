<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('image_url');
            $table->text('description');
            $table->integer('price');
            $table->string('slug')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('productcategory_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

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
        Schema::dropIfExists('umkms');
    }
};
