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
        Schema::create('end_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->string('department_name');
            $table->string('job_title');
            $table->text('postal_address');
            $table->string('phone_number');
            $table->text('remark');
            $table->date('end_date');
            $table->string('renewal_notice_file')->nullable();

            // End of Employment Contract Details
            $table->string('employer_name')->nullable();
            $table->string('letter_title')->nullable();
            $table->date('signed_date')->nullable();
            $table->date('started_date')->nullable();
            $table->integer('days_worked')->nullable();
            $table->string('on_behalf_of')->nullable();
            $table->string('designation')->nullable();
            $table->string('hr_name')->nullable();
            $table->string('signature_file')->nullable();
            $table->string('employee_designation')->nullable();
            $table->string('employee_signature_file')->nullable();

            // Non-Renewal Contract Details
            $table->string('job_department')->nullable();
            $table->date('contract_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('non_renewal_letter_title')->nullable();

            // Status and Workflow
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected', 'Completed'])->default('Draft');
            $table->enum('stage', ['Initiated', 'HR Review', 'Manager Review', 'Final Approval', 'Completed'])->default('Initiated');
            $table->text('hr_recommendations')->nullable();
            $table->text('manager_recommendations')->nullable();

            // Audit fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
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
        Schema::dropIfExists('end_contracts');
    }
};
