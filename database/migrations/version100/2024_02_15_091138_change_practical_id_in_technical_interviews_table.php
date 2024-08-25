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
    //     Schema::table('technical_interviews', function (Blueprint $table) {
    //         // Use the nullable method directly
    //         $table->integer('practical_test_id')->nullable();
    //     });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    //     Schema::table('technical_interviews', function (Blueprint $table) {
    //         $table->dropColumn('practical_test_id');
    //     });
    }
};
