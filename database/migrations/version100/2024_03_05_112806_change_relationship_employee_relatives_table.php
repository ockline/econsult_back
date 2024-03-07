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

            DB::statement('ALTER TABLE employee_reletives ALTER COLUMN relationship_id TYPE BIGINT USING relationship_id::BIGINT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_reletives', function (Blueprint $table) {

            DB::statement('ALTER TABLE employee_reletives ALTER COLUMN relationship_id TYPE INTEGER USING relationship_id::INTEGER');
        });
    }
};
