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
        Schema::create('contract_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contract_name');
            $table->integer('employee_id')->unsigned();
            $table->integer('document_id')->unsigned();
            $table->integer('document_group_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('size')->nullable();
            $table->float('ext')->nullable();
            $table->string('mine')->nullable();
            $table->boolean('document_used')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('RESTRICT');
            // $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_id')->references('id')->on('documents')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('document_group_id')->references('id')->on('document_groups')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_documents');
    }
};
