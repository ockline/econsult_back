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
        Schema::create('resignation_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('comments')->nullable();
            $table->date('report_date')->nullable();
            $table->date('received_date')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('result')->nullable();
            $table->unsignedBigInteger('attended_by')->nullable();
            $table->date('attended_date')->nullable();
            $table->enum('status', ['Initiated', 'Reviewed', 'Approved', 'Rejected', 'Returned'])->default('Initiated');
            $table->string('stage')->nullable();
            $table->string('function_name')->nullable();
            $table->string('previous_stage')->nullable();
            $table->string('next_stage')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resignation_id')->references('id')->on('resignations')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('resignation_workflows')->onDelete('cascade');
            $table->foreign('attended_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resignation_workflows');
    }
};
