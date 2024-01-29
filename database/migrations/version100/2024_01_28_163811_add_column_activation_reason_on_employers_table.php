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
        Schema::table('employers', function (Blueprint $table) {
            $table->text('activate_reason')->nullable();
            $table->text('deactivate_reason')->nullable();
            $table->text('activate_date')->nullable();
            $table->text('deactivate_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
             $table->dropColumn('activate_reason');
            $table->dropColumn('deactivate_reason');
            $table->dropColumn('activate_date');
            $table->dropColumn('deactivate_date');
        });
    }
};
