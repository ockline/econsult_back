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
            $table->string('duration_deployment')->nullable();
            $table->unsignedBigInteger('national_id')->nullable();
            $table->string('birth_place')->nullable();
            $table->unsignedBigInteger('job_title_id');
            $table->text('purpose')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_identifications', function (Blueprint $table) {
            $table->dropColumn('duration_deployment');
            $table->dropColumn('national_id');
            $table->dropColumn('birth_place');
            $table->dropColumn('job_title_id');
            $table->dropColumn('purpose');
        });
    }
};
