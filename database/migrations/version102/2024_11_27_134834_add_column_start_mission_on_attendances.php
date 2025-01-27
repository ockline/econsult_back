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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('start_of_mission')->nullable()->comment('M');
            $table->string('end_of_mission')->nullable();
            $table->string('end_of_service')->nullable()->comment('EOS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
           $table->dropColumn('start_of_mission');
            $table->dropColumn('end_of_mission');
            $table->dropColumn('end_of_service');
        });
    }
};
