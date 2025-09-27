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
        Schema::create('resignation_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resignation_id');
            $table->string('name');
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('document_group_id')->nullable();
            $table->string('description');
            $table->string('size')->nullable();
            $table->string('ext')->nullable();
            $table->string('mine')->nullable();
            $table->string('document_used')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('resignation_id')->references('id')->on('resignations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resignation_attachments');
    }
};
