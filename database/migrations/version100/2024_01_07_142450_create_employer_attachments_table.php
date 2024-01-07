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
        Schema::create('employer_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('employer_id')->unsigned();
            $table->integer('document_id')->unsigned();
            $table->integer('document_group_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('size')->nullable();
            $table->float('ext')->nullable();
            $table->string('mine')->nullable();
            $table->boolean('document_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_id')->references('id')->on('documents')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_group_id')->references('id')->on('document_groups')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_attachments');
    }
};
