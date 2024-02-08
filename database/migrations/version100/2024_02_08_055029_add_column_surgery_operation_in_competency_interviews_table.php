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
            $table->integer('surgery_operation')->comment('1 - Yes, 2 -No');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->dropColumn('surgery_operation');
        });
    }
};
