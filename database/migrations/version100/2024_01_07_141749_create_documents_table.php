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
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('document_group_id')->unsigned();
            $table->string('description')->nullable();
            $table->integer('isrecurring')->default(0)->comment('0 it does not repeat, 1 - is repeated');
            $table->integer('ismandatory')->default(0)->comment('0 not mandatory, 1 - must have(required)');
            $table->integer('isactive')->default(1)->comment('1 active, 2 - inactive');
            $table->integer('anysource')->nullable()->comment('1 online, 2 - inside');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('document_group_id')->references('id')->on('document_groups')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
