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
            if (!Schema::hasColumn('employees', 'place_issued')) {
                $table->text('place_issued')->nullable();
            } else {
                // If the column exists, modify it
                $table->text('place_issued')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('place_issued');
        });
    }
};
