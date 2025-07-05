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
        Schema::create('disciplinary_appeal_attachments', function (Blueprint $table) {
              $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('appeal_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('document_group_id')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('size')->nullable(); // in bytes
            $table->string('ext', 10)->nullable(); // e.g., 'pdf'
            $table->string('mine')->nullable(); // should be 'mime', typo corrected below
            $table->boolean('document_used')->default(false);
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_appeal_attachments');
    }
};
