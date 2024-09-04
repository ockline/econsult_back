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
        Schema::create('workflow_tracks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workflow_history_id');
            $table->integer('status')->comment('0 - Not attended, 1 - Attended');
            $table->timestamp('created_date')->nullable(); // Use timestamp for date and time
            $table->timestamp('attended_date')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable(); // Foreign key or reference to another user
            $table->unsignedBigInteger('attended_by')->nullable()->comment('who have attend  workflow');
            $table->integer('aging')->nullable()->comment('time since file created to closed');
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('workflow_history_id')->references('id')->on('workflow_histories');
            // $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_tracks');
    }

};
