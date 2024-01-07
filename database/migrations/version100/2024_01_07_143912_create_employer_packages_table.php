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
        Schema::create('employer_packages', function (Blueprint $table) {
           $table->increments('id');
            $table->bigInteger('package_id')->unsigned()->index('package_id');
            $table->integer('employer_id')->unsigned();
            $table->text('description')->nullable();
            $table->integer('status')->default(1)->comment('1 active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('package_id')->references('id')->on('packages')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_packages');
    }
};
