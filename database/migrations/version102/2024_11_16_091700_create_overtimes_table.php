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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('employer_id')->nullable();
            $table->string('employee_name');
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('shift')->nullable();
            $table->integer('ot_hours');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('overtime_date')->nullable();
            $table->string('time_in')->nullable();
            $table->string('time_out')->nullable();
            $table->string('date')->nullable();
$table->integer('status')->nullable()->comment('1-submitted, 2-reviewed, 3-Approved, 4-Rejected,5-Reversed');
            $table->string('public_holiday')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
