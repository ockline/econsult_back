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
        Schema::table('misconducts', function (Blueprint $table) {
             $table->string('misconduct_cause')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misconducts', function (Blueprint $table) {
            $table->integer('misconduct_cause')->change();
        });
    }
};
