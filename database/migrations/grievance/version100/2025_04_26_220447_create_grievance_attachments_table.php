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
        Schema::create('grievance_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // file name
            $table->unsignedBigInteger('grievance_id')->nullable(); // link to grievance
            $table->unsignedBigInteger('document_id')->nullable(); // if linking to document table
            $table->unsignedBigInteger('document_group_id')->nullable(); // group id if needed
            $table->text('description')->nullable(); // optional file description
            $table->bigInteger('size')->nullable(); // file size
            $table->string('ext', 10)->nullable(); // file extension, e.g., .pdf, .docx
            $table->string('mine', 50)->nullable(); // MIME type (should be "mime" not "mine", but keeping yours)
            $table->string('document_used')->nullable(); // usage info if needed
            $table->string('file_path')->nullable(); // where file is stored (relative path)
            $table->timestamps();
            $table->softDeletes(); // if you want soft delete (optional, but good)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance_attachments');
    }
};
