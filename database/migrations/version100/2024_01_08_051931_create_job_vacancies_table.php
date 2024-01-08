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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->bigInteger('job_title_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('type_vacancy_id')->unsigned();
            $table->date('position_vacant');
            $table->date('date_application');
            $table->date('deadline_date');
            $table->date('hr_interview_date');
            $table->date('tech_interview_date');
            $table->date('apointment_date');
            $table->text('work_station');
            $table->text('replacement_reason')->nullable();
            $table->integer('age');
            $table->text('accademic');
            $table->text('professional');
            $table->float('salary_range');
            $table->text('others')->nullable();
            $table->text('additional_comment')->nullable();
            $table->integer('status')->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('type_vacancy_id')->references('id')->on('type_vacancies')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
