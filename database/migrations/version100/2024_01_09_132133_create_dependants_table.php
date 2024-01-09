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
        Schema::create('dependants', function (Blueprint $table) {
            $table->id();
             $table->integer('employee_id')->unsigned();
            $table->integer('social_record_id')->unsigned();
            $table->string('dependant_name')->nullable();
            $table->date('dob')->nullable();
            $table->text('relationship');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('social_record_id')->references('id')->on('social_records')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependants');
    }
};
