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
        Schema::create('performance_capacities', function (Blueprint $table) {
            $table->id();
            $table->integer('incapacity_type');
            $table->bigInteger('employee_id');
            $table->text('investigation_report');
            $table->string('investigation_date');
            $table->string('investigation_time')->nullable();
            $table->text('subject_matter')->nullable();
            $table->text('investigator_name')->nullable();
            $table->text('investigator_signature')->nullable();
            $table->text('investigator_designation')->nullable();
            $table->text('suffering_from')->nullable();
            $table->string('suffering_period')->nullable();
            $table->text('daily_duties')->nullable();
            $table->text('challenge_daily_duties')->nullable()->comment('according to above answer what are the challenges on attending your daily duties');
            $table->text('alternative_task')->nullable()->comment('what are the alternative task /job you may suggest do?');
            $table->text('partient_suggestion')->nullable()->comment('Patient suggestions on his/her illness and employment fortune?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_capacities');
    }
};
