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
        Schema::create('disciplinaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->unsignedBigInteger('misconduct_id')->nullable();
            $table->string('remarks', 4000)->nullable();
            $table->integer('count')->nullable();
            $table->boolean('is_charge_sheet')->default(false);
            $table->date('issue_charge_sheet_date')->nullable()->comment('in case  charge sheet issued');
            $table->boolean('is_notice_appeal')->default(false);
            $table->boolean('is_employee_notified')->default(false);
            $table->date('employee_notification_date')->nullable();
            $table->boolean('is_employee_appeal')->default(false);
            $table->date('appeal_date')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->unsignedBigInteger('initiated_by')->nullable();
            $table->date('initiated_date')->nullable();
            $table->date('decision_released_date')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->date('modified_date')->nullable();
            $table->timestamps(); // includes created_at and updated_at
            $table->softDeletes(); // adds deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinaries');
    }
};
