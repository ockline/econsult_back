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
        Schema::table('social_records', function (Blueprint $table) {
            // Change data type of national_id to string
            $table->string('relative_working')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_records', function (Blueprint $table) {
            // If needed, revert the data type change in the down method
            $table->integer('relative_working')->nullable()->change();
        });
    }
};
