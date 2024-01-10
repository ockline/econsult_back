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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();

            $table->string('name');
                    $table->integer('parent_id')->nullable();
                    $table->integer('external_id')->nullable();
                    $table->date('opening_date')->nullable();
                    $table->integer('region_id')->unsigned();
                    $table->integer('isactive');
                    $table->timestamps();
                    $table->softDeletes();
                    $table->foreign('region_id')->references('id')->on('regions')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
