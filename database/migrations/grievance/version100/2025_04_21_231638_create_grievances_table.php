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
        Schema::create('grievances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('employer_id');
            $table->string('grievance_reason',4000)->nullable()->comment('Sababu ya malalamiko');
            $table->string('grievance_resolution', 4000)->nullable()->comment('Suluhisho lililotafutwa:');
            $table->string('report_date')->nullable();
            $table->string('resolution_date')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->string('initiated_by')->nullable();
            $table->date('initiated_date');
            $table->string('source')->default('system')->comment('system, portal, manual');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievances');
    }
};
