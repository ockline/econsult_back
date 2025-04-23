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
        Schema::create('grievance_workflows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('grievance_id');
            $table->integer('user_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('status');
            $table->string('comments', 4000);
            $table->string('stage');
            $table->string('action_taken', 4000)->nullable();
            $table->string('recommendation', 4000)->nullable();
            $table->string('result', 4000)->nullable();
            $table->date('received_date')->nullable();
            $table->string('attended_by');
            $table->date('attended_date');
            $table->string('function_name');
            $table->string('previous_stage')->nullable();
            $table->string('next_stage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance_workflows');
    }
};
