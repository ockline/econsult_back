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
        Schema::create('bank_branches', function (Blueprint $table) {
               $table->increments('id');
			$table->string('name', 100);
			$table->string('alias', 50)->nullable();
            $table->integer('bank_id')->unsigned()->index('bank_id');
			$table->string('descriptions', 100)->nullable();
            $table->timestamps();
            $table->foreign('bank_id')->references('id')->on('banks')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_branches');
    }
};
