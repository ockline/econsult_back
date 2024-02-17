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
        Schema::table('technical_interviews', function (Blueprint $table) {

            if (!Schema::hasColumn('technical_interviews', 'cost_center_id')) {
                $table->unsignedBigInteger('cost_center_id')->nullable();
            }
            if (!Schema::hasColumn('technical_interviews', 'cost_number')) {
                $table->unsignedBigInteger('cost_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('technical_interviews', function (Blueprint $table) {
            if (Schema::hasColumn('technical_interviews', 'cost_center_id')) {
                $table->dropColumn('cost_center_id');
            }
            if (Schema::hasColumn('technical_interviews', 'cost_number')) {
                $table->dropColumn('cost_number');
            }
        });
    }
};
