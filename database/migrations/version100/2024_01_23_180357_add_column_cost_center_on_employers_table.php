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
        Schema::table('employers', function (Blueprint $table) {
            $table->integer('ward_id')->nullable();
            $table->integer('cost_center')->nullable()->comment('1 - yes (if yes add to the packages seeder), 2 - No');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('ward_id');
            $table->dropColumn('cost_center');
        });
    }
};
