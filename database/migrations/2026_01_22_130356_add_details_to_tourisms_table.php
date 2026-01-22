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
        Schema::table('tourisms', function (Blueprint $table) {
            $table->text('address')->nullable()->after('content');
            $table->string('open_hours')->nullable()->after('address');
            $table->text('facilities')->nullable()->after('open_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tourisms', function (Blueprint $table) {
            $table->dropColumn(['address', 'open_hours', 'facilities']);
        });
    }
};
