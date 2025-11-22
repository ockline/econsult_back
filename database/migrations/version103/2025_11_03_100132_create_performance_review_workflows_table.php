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
        Schema::create('performance_review_workflows', function (Blueprint $table) {
            $table->id();
            $table->integer('review_id')->unsigned();
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->string('status');
            $table->string('comments', 4000)->nullable();
            $table->string('attended_by');
            $table->string('previous_stage')->nullable();
            $table->string('current_stage')->nullable();
            $table->string('function_name')->nullable();
            $table->date('attended_date');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_review_workflows');
    }
};
