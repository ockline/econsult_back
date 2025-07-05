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
            $table->integer('initiated_by')->nullable();
            $table->timestamp('initiated_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misconducts', function (Blueprint $table) {
            $table->dropColumn('initiated_by');
            $table->dropColumn('initiated_date');
        });
    }
};
