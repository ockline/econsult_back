<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wcf_occupational', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('employee_number')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('wcf_case_number')->nullable();
            $table->string('incident_type')->nullable();
            $table->string('employer_reported_by')->nullable();
            $table->date('incident_date')->nullable();
            $table->text('reason_for_termination')->nullable();
            $table->string('sick_leave_less')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('payment_status')->nullable();
            $table->string('health_status')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('cause')->nullable();
            $table->string('status')->default('Active');
            $table->text('recommendation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wcf_occupational');
    }
};
