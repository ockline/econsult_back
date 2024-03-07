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
        Schema::table('social_records', function (Blueprint $table) {
            // Check if the columns exist before attempting to add them
            if (!Schema::hasColumn('social_records', 'employer_id')) {
                $table->integer('employer_id')->nullable();
            }

            if (!Schema::hasColumn('social_records', 'section_id')) {
                $table->integer('section_id')->nullable();
            }

            if (!Schema::hasColumn('social_records', 'tin')) {
                $table->integer('tin')->nullable();
            }

            // Add new columns
            if (!Schema::hasColumn('social_records', 'ward_id')) {
                $table->integer('ward_id')->nullable();
            }

            if (!Schema::hasColumn('social_records', 'city_id')) {
                $table->integer('city_id')->nullable();
            }
        });

        // Update data from old columns to new columns
        DB::statement('UPDATE social_records SET ward_id = CAST(ward AS INTEGER), city_id = CAST(city AS INTEGER)');

        Schema::table('social_records', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn('ward');
            $table->dropColumn('city');

            // Change data type of new columns
            $table->integer('ward_id')->nullable()->change();
            $table->integer('city_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_records', function (Blueprint $table) {
            // Reverse changes for new columns
            $table->renameColumn('ward_id', 'ward');
            $table->renameColumn('city_id', 'city');

            // Reverse changes for data types
            $table->string('ward')->nullable()->change();
            $table->string('city')->nullable()->change();

            // Drop new columns
            $table->dropColumn('ward_id');
            $table->dropColumn('city_id');

            $table->dropColumn('employer_id');
            $table->dropColumn('section_id');
            $table->dropColumn('tin');
        });
    }
};
