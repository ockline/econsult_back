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
        Schema::create('workflow_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('user_id')->comment('who have initiate workflow');
            $table->text('model_type')->nullable()->comment('keep name of model as per workflow initiated');
            $table->unsignedBigInteger('attended_by')->nullable(); // Foreign key or reference to another user
            $table->integer('status');
            $table->text('comments')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->timestamp('attended_date')->nullable();
            $table->integer('level')->nullable(); // Assuming this is a string field
            $table->integer('stage')->nullable();
            $table->integer('aging')->nullable()->comment();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_histories');
    }
};
