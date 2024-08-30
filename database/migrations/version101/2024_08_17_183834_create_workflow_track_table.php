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
            $table->text('model_type')->nullable()->comment('keep name of model as per workflow initiated');
            $table->integer('status');
            $table->integer('parent_id')->nullable();
            $table->timestamp('created_date')->nullable(); // Use timestamp for date and time
            $table->timestamp('received_date')->nullable();
            $table->timestamp('attended_date')->nullable();
            $table->unsignedBigInteger('attended_by')->nullable(); // Foreign key or reference to another user
            $table->integer('level')->nullable(); // Assuming this is a string field
            $table->integer('stage')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('who have initiate workflow');
            $table->integer('aging')->nullable()->comment();
            $table->timestamps(); // Adds created_at and updated_at columns
            $table->softDeletes();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('attended_by')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
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
