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
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->text('surgery_operation_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->dropColumn('surgery_operation_remark');
        });
    }
};
