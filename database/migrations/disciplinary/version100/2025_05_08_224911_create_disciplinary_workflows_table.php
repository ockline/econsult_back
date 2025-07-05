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
        Schema::create('disciplinary_workflows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disciplinary_id');
            $table->integer('user_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('status');
            $table->string('comments', 4000)->nullable();
            $table->string('stage');
            $table->string('disciplinary_outcome')->nullable()->comment('if hearing commettee final resolution');
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
        Schema::dropIfExists('disciplinary_workflows');
    }
};
