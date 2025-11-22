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
        Schema::table('performance_review_workflows', function (Blueprint $table) {
            if (!Schema::hasColumn('performance_review_workflows', 'return_to_user_id')) {
                $table->unsignedBigInteger('return_to_user_id')->nullable()->after('attended_by');
            }

            if (!Schema::hasColumn('performance_review_workflows', 'return_to_user_name')) {
                $table->string('return_to_user_name')->nullable()->after('return_to_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_review_workflows', function (Blueprint $table) {
            if (Schema::hasColumn('performance_review_workflows', 'return_to_user_id')) {
                $table->dropColumn('return_to_user_id');
            }

            if (Schema::hasColumn('performance_review_workflows', 'return_to_user_name')) {
                $table->dropColumn('return_to_user_name');
            }
        });
    }
};

