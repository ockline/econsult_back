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
        Schema::table('dependants', function (Blueprint $table) {
          $table->integer('dependent_id');
          $table->text('other_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dependants', function (Blueprint $table) {
          $table->dropColumn('dependent_id');
          $table->dropColumn('other_relationship');
        });
    }
};
