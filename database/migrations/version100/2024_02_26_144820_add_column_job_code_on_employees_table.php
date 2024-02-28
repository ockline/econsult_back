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
            $table->integer('job_code')->nullable();
            $table->integer('military_number')->nullable();
           $table->text('present_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
           $table->dropColumn('job_code');
            $table->dropColumn('military_number');
           $table->dropColumn('present_address');
        });
    }
};
