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
        Schema::create('job_vacancy_documents', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name');
            $table->integer('job_vacancy_id')->unsigned();
            $table->integer('document_id')->unsigned();
            $table->integer('document_group_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('size')->nullable();
            $table->float('ext')->nullable();
            $table->string('mine')->nullable();
            $table->boolean('document_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_id')->references('id')->on('documents')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_group_id')->references('id')->on('document_groups')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancy_documents');
    }
};
