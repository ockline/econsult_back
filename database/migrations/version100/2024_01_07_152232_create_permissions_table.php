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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('display_name');
            $table->integer('permission_group_id')->unsigned();
            $table->string('description')->nullable();
            $table->boolean('ischecker')->nullable();
            $table->boolean('can_make_check')->nullable();
            $table->integer('check_parent')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('permission_group_id')->references('id')->on('permission_group')->onUpdate('CASCADE')->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
