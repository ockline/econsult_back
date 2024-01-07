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
        Schema::create('job_desc_transactions', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name', 100);
            $table->integer('job_title_id')->unsigned()->index('job_title_id');
            $table->integer('employer_id')->unsigned();
            $table->string('description')->nullable();
            $table->integer('status')->default(1)->comment('1 active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_desc_transactions');
    }
};
