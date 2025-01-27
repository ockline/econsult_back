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
        Schema::create('industrial_documents', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('source_name');
            $table->integer('employee_id')->unsigned();
            $table->integer('document_id')->ullable();
            $table->integer('document_group_id')->nullable();
            $table->text('files');
            $table->string('size')->nullable();
            $table->float('ext')->nullable();
            $table->string('mine')->nullable();
            $table->boolean('document_used')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_documents');
    }
};
