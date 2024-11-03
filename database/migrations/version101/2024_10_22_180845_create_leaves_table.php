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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->integer('leave_type_id');
            $table->integer('employer_id')->nullable();
            $table->integer('employee_id');
            $table->integer('balance_days')->nullable()->comment('days remain after spend leave per year');
            $table->string('financial_year')->nullable();
            $table->integer('all_balance')->nullable();
            $table->string('start_date')->comment('date to start leave');
            $table->string('end_date')->comment('date to end leave');
            $table->integer('status')->nullable()->comment('1 - Initiated, 2 - Reviewed, 3 - Approved, 4 - Reversed');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
