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
        Schema::table('job_desc_transactions', function (Blueprint $table) {
               $table->text('name')->change();
               $table->text('description')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_desc_transactions', function (Blueprint $table) {
               $table->string('name', 100)->change();
               $table->string('description')->nullable()->change();
        });
    }
};
