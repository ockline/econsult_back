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
        Schema::table('competencies_transactions', function (Blueprint $table) {
          $table->integer('competency_id')->nullable()->change();
          $table->integer('competency__subject_id')->nullable()->change();
          $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competencies_transactions', function (Blueprint $table) {
            $table->integer('competency_id')->nullable(false)->change();
            $table->integer('competency__subject_id')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
};
