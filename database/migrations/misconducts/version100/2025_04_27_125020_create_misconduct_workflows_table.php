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
        Schema::create('misconduct_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('misconduct_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('status')->nullable();
            $table->string('comments', 4000)->nullable();
            $table->string('stage')->nullable();
            $table->string('case_decision')->nullable();
            $table->string('action_taken', 4000)->nullable();
            $table->unsignedBigInteger('attended_by')->nullable();
            $table->timestamp('attended_date')->nullable();
            $table->string('function_name')->nullable();
            $table->string('previous_stage')->nullable();
            $table->string('next_stage')->nullable();
             $table->timestamp('decision_release_date')->nullable();
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes();

            // Optional: Foreign keys if needed
            // $table->foreign('misconduct_id')->references('id')->on('misconducts')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misconduct_workflows');
    }
};
