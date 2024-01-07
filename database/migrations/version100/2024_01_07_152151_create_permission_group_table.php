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
        Schema::create('permission_group', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('alias', 20)->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(1)->comment('1 active, 2 - inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_group');
    }
};
