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
     Schema::create('leave_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('financial_year', 9); // e.g. 2024-2025
            $table->string('comments', 4000)->nullable();
            $table->string('status', 50);
            $table->string('function_name', 100)->nullable();
            $table->string('current_stage', 100);
            $table->string('next_stage', 100)->nullable();
            $table->unsignedBigInteger('attended_by')->nullable();
            $table->timestamp('attended_date')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('updated_date')->nullable();
            $table->timestamps();

            // Optional: Add foreign keys if those tables exist
            $table->foreign('leave_id')->references('id')->on('leaves')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('attended_by')->references('id')->on('users');
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leave_workflows');
    }
};

