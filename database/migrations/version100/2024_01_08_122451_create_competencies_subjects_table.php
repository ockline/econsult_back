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
        Schema::create('competencies_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('competency_id')->unsigned();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('competency_id')->references('id')->on('competencies')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencies_subjects');
    }
};
