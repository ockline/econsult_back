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
        Schema::create('emp_cost_centers', function (Blueprint $table) {
           $table->increments('id');
            $table->bigInteger('cost_center_id')->unsigned()->index('cost_center_id');
            $table->integer('employer_id')->unsigned();
            $table->text('description')->nullable();
            $table->integer('status')->default(1)->comment('1 active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_cost_centers');
    }
};
