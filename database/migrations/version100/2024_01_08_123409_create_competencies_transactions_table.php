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
        Schema::create('competencies_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('competency_id')->unsigned();
            $table->integer('competency__subject_id')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('competency_id')->references('id')->on('competencies')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('competency__subject_id')->references('id')->on('competencies_subjects')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencies_transactions');
    }
};
