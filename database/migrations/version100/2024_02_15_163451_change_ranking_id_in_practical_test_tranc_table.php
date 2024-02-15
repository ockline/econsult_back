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
            if (!Schema::hasColumn('practical_test_tranc', 'test_marks')) {
                $table->integer('test_marks')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practical_test_tranc', function (Blueprint $table) {
            if (Schema::hasColumn('practical_test_tranc', 'test_marks')) {
                $table->dropColumn('test_marks');
            }
        });
    }
};
