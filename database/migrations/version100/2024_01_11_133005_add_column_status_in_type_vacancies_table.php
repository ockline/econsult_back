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
        Schema::table('type_vacancies', function (Blueprint $table) {
            $table->integer('status')->nullable()->comment('2 for application of Employee ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_vacancies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
