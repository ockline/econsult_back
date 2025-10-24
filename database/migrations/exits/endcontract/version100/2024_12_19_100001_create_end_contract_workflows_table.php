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
        Schema::create('end_contract_workflows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('end_contract_id');
            $table->text('comments')->nullable();
            $table->text('recommendation')->nullable();
            $table->datetime('received_date')->nullable();
            $table->unsignedBigInteger('attended_by')->nullable();
            $table->datetime('attended_date')->nullable();
            $table->string('status'); // Initiated, Reviewed, Approved, Rejected, Returned
            $table->string('stage'); // HR Review, Manager Review, Final Approval, etc.
            $table->string('function_name'); // End Contract Initiation, HR Review, etc.
            $table->string('previous_stage')->nullable();
            $table->string('next_stage')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('end_contract_id')->references('id')->on('end_contracts')->onDelete('cascade');
            $table->foreign('attended_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('end_contract_workflows');
    }
};
