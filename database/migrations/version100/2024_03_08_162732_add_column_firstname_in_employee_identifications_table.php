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
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_identifications', function (Blueprint $table) {
             $table->dropColumn('firstname');
            $table->dropColumn('middlename');
            $table->dropColumn('lastname');
        });
    }
};
