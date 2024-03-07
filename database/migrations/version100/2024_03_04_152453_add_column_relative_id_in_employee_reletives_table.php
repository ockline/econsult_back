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
        Schema::table('employee_reletives', function (Blueprint $table) {
            $table->integer('relative_id');
            $table->text('relative_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_reletives', function (Blueprint $table) {
            $table->dropColumn('relative_id');
            $table->dropColumn('relative_address');
        });
    }
};
