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
        Schema::table('competency_interviews', function (Blueprint $table) {
             $table->bigInteger('cost_center_id')->nullable()->change();
             $table->bigInteger('cost_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competency_interviews', function (Blueprint $table) {
             $table->bigInteger('cost_center_id')->nullable(false)->change();
             $table->bigInteger('cost_number')->nullable(false)->change();
        });
    }
};
