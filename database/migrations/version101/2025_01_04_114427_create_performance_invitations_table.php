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
        Schema::create('performance_invitations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('capacity_id');
            $table->text('meeting_place');
            $table->string('time')->nullable();
            $table->string('meeting_date');
            $table->text('invitees')->nullable()->comment('who will attend meeting');
            $table->text('invitation_letter_title')->nullable();
            $table->text('invitees_email_address')->nullable();
            $table->text('invitees_phone_no')->nullable();
            $table->text('invitation_letter_attachment')->nullable();
            $table->string('pospone_date')->nullable();
            $table->text('pospone_remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_invitations');
    }
};
