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
            $table->integer('personal_type')->nullable()->change();
            $table->integer('employer_id')->nullable()->change();
            $table->integer('site_pass_type')->nullable()->change();
            $table->integer('department_id')->nullable()->change();
            $table->integer('job_title_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_identifications', function (Blueprint $table) {
            $table->dropColumn('personal_type');
            $table->dropColumn('employer_id');
            $table->dropColumn('site_pass_type');
            $table->dropColumn('department_id');
            $table->dropColumn('job_title_id');
        });
    }
};
