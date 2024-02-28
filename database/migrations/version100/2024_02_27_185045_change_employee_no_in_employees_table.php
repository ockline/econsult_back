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
            // If the column exists, modify it
            if (Schema::hasColumn('employees', 'employee_no')) {
                $table->bigInteger('employee_no')->autoIncrement()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_no');
        });
    }
};
