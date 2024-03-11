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
        Schema::table('employee_identifications', function (Blueprint $table) {
           $table->renameColumn('section_id', 'section')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_identifications', function (Blueprint $table) {
        $table->renameColumn('section', 'section_id');
        });
    }
};
