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
        Schema::table('job_desc_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('job_desc_transactions', 'employer_id')) {
                $table->unsignedBigInteger('employer_id')->nullable();
            }
            if (!Schema::hasColumn('job_desc_transactions', 'job_title_id')) {
                $table->unsignedBigInteger('job_title_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_desc_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('employer_id')->nullable()->change();
            $table->unsignedBigInteger('job_title_id')->nullable()->change();
        });
    }
};
