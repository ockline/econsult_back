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
        Schema::create('employer_allowances', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('employer_id')->unsigned();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_allowances');
    }
};
