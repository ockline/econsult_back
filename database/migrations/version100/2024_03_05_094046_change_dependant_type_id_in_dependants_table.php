<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dependants', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->change();
             $table->unsignedBigInteger('social_record_id')->change();
             DB::statement('ALTER TABLE dependants ALTER COLUMN dependant_type_id TYPE BIGINT USING dependant_type_id::BIGINT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dependants', function (Blueprint $table) {
             $table->integer('employee_id')->nullable()->change();
             $table->integer('social_record_id')->nullable()->change();
            DB::statement('ALTER TABLE dependants ALTER COLUMN dependant_type_id TYPE INTEGER USING dependant_type_id::INTEGER');
        });
    }
};
