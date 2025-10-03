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
        Schema::create('resignations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->string('department_name');
            $table->string('job_title');
            $table->text('postal_address');
            $table->string('phone_number');
            $table->text('remark');
            $table->date('resignation_date');
            $table->string('resignation_notice_file')->nullable();
            $table->string('resignation_form_file')->nullable();
            $table->string('resignation_letter_file')->nullable();
            $table->string('certificate_of_service_file')->nullable();
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'])->default('Draft');
            $table->enum('stage', ['Initiated', 'HR Review', 'Manager Review', 'Final Approval', 'Completed'])->default('Initiated');
            $table->text('hr_recommendations')->nullable();
            $table->text('manager_recommendations')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resignations');
    }
};
