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
        Schema::create('exit_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('end_contract_id');
            $table->string('document_name');
            $table->string('document_type', 50)->nullable();
            $table->string('attachment_file');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('end_contract_id')
                  ->references('id')
                  ->on('end_contracts')
                  ->onDelete('cascade');
            
            // Indexes for better query performance
            $table->index('end_contract_id');
            $table->index('document_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_attachments');
    }
};
