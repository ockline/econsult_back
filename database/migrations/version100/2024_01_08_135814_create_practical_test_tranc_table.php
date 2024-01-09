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
        Schema::create('practical_test_tranc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('practical_test_id')->unsigned();
            $table->integer('technical_interview_id')->unsigned();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('practical_test_id')->references('id')->on('practical_tests')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('technical_interview_id')->references('id')->on('technical_interviews')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practical_test_tranc');
    }
};
