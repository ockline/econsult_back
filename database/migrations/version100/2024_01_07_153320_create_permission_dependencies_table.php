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
        Schema::create('permission_dependencies', function (Blueprint $table) {
            $table->id();
           $table->integer('permission_id')->unsigned();
            $table->integer('dependency_id')->unsigned()->index('dependency_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('CASCADE')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_dependencies');
    }
};
