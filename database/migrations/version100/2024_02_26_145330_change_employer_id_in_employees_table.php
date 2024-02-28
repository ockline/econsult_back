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
        Schema::table('employees', function (Blueprint $table) {
            $table->integer('employer_id')->nullable()->change();
            $table->bigInteger('cost_center_id')->nullable()->change();
            $table->bigInteger('cost_number')->nullable()->change();
            $table->integer('package_id')->nullable()->change();
            $table->integer('department_id')->nullable()->change();
            $table->text('account_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employer_id');
            $table->dropColumn('cost_center_id');
            $table->dropColumn('cost_number');
            $table->dropColumn('package_id');
            $table->dropColumn('department_id');
            $table->dropColumn('account_name');
        });
    }
};
