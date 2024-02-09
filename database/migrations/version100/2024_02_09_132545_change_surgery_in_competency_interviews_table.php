<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Modify the existing migration file that added the competency_interviews table
public function up(): void
{
    Schema::table('competency_interviews', function (Blueprint $table) {
        // Check if the column exists before trying to add it
        if (!Schema::hasColumn('competency_interviews', 'surgery_operation')) {
            $table->integer('surgery_operation')->nullable()->comment('1-Yes, 2-No');
        }
    });
}

public function down(): void
{
    Schema::table('competency_interviews', function (Blueprint $table) {
        // Check if the column exists before trying to drop it
        if (Schema::hasColumn('competency_interviews', 'surgery_operation')) {
            $table->dropColumn('surgery_operation');
        }
    });
}



};
