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
        Schema::create('disciplinary_invitees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invitation_id')->nullable();
            $table->string('invitation_type');
            $table->string('invitee_name')->nullable();
            $table->string('designation')->nullable();
            $table->date('invitation_date')->nullable();
            $table->string('invited_by')->nullable();
            $table->timestamps(); // includes created_at and updated_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_invitees');
    }
};
