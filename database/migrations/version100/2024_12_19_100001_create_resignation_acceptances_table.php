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
        Schema::create('resignation_acceptances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->date('acceptance_date');
            $table->string('employee_name');
            $table->string('job_title');
            $table->text('postal_address');
            $table->date('letter_dated');
            $table->string('service_of');
            $table->date('effective_from');
            $table->date('started_work');
            $table->string('hr_name');
            $table->string('hr_designation');
            $table->string('hr_signature_file')->nullable();
            $table->string('employee_signature_file')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resignation_id')->references('id')->on('resignations')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resignation_acceptances');
    }
};
