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
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('created_by')->nullable()->comment('user that create leave can be  from portal table or core');
            $table->date('created_date')->nullable();
            $table->string('source')->nullable()->comment('portal , system, Manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('created_date');
            $table->dropColumn('source');
        });
    }
};
