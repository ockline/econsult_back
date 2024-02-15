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
        Schema::table('practical_test_tranc', function (Blueprint $table) {
           $table->integer('test_marks');
            $table->integer('ranking_creterial_id');
            $table->text('practicl_test_remark')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practical_test_tranc', function (Blueprint $table) {
            $table->dropColumn('test_marks');
             $table->dropColumn('ranking_creterial_id');
            $table->dropColumn('practicl_test_remark');
        });
    }
};
