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
        Schema::table('employees', function (Blueprint $table) {
            // Check if the column exists before modifying it
            if (!Schema::hasColumn('employees', 'national_id')) {
                $table->unsignedBigInteger('national_id')->nullable();
            } else {
                // If the column exists, modify it
                $table->unsignedBigInteger('national_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('national_id');
        });
    }

};
