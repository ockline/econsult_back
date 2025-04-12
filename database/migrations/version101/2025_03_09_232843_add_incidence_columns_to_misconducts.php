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
        Schema::table('misconducts', function (Blueprint $table) {
            $table->text('incidence_remarks')->nullable();
            $table->string('incidence_reported_by')->nullable()->index(); // Assuming it references a user
            $table->date('incidence_reported_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misconducts', function (Blueprint $table) {
             $table->dropColumn(['incidence_remarks', 'incidence_reported_by', 'incidence_reported_date']);
        });
    }
};
