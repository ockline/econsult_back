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
        Schema::create('disciplinary_invitations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('disciplinary_id')->nullable();
            $table->string('remarks', 4000)->nullable();
            $table->integer('count')->nullable();
            $table->date('hearing_date')->nullable();
            $table->time('hearing_time')->nullable();
            $table->string('hearing_venue')->nullable();
            $table->string('hearing_location')->nullable();
            $table->date('rescheduled_date')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->unsignedBigInteger('initiated_by')->nullable();
            $table->date('initiated_date')->nullable();
            $table->string('postpone_reason', 4000)->nullable();
            $table->date('pospone_date')->nullable();
            $table->string('source')->nullable();
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->date('modified_date')->nullable();
            $table->timestamps(); // includes created_at and updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_invitations');
    }
};
