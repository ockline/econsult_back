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
        Schema::table('social_records', function (Blueprint $table) {
            // Check if the columns exist before attempting to add them
            if (!Schema::hasColumn('social_records', 'employer_id')) {
                $table->integer('employer_id')->nullable();
            }

            if (!Schema::hasColumn('social_records', 'section_id')) {
                $table->integer('section_id')->nullable();
            }

           
        });



        Schema::table('social_records', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn('employer_id');
            $table->dropColumn('section_id');

            // Make employer_id and section_id nullable
            $table->integer('employer_id')->nullable()->change();
            $table->integer('section_id')->nullable()->change();
        });
    }


};
