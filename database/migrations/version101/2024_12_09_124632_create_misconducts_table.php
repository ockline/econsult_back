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
        Schema::create('misconducts', function (Blueprint $table) {
            $table->id();
            $table->integer('misconduct_cause')->comment('id from misconduct types');
            $table->bigInteger('employee_id');
            $table->integer('employer_id');
            $table->string('misconduct_date');
            $table->string('employee_name')->nullable();
            $table->text('investigation_report')->nullable();
            $table->text('dismiss_remarks')->nullable();
            $table->string('dismiss_date')->nullable();
            $table->integer('count')->default(0);
            $table->integer('investigation_report_attachment')->default(0)->comment('0 -in case not attached, 1- attached');
            $table->integer('show_cause_letter')->default(0)->comment('1- in case attached  that letter');
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misconducts');
    }
};
