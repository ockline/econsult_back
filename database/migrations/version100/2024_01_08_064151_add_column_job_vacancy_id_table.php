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
        Schema::table('job_desc_transactions', function (Blueprint $table) {
            $table->bigInteger('job_vacancy_id')->unsigned();
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_desc_transactions', function (Blueprint $table) {
            //
        });
    }
};
