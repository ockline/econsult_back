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
        Schema::table('employee_reletives', function (Blueprint $table) {
           $table->renameColumn('relationship', 'relationship_id');
            $table->string('other_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_reletives', function (Blueprint $table) {
           $table->renameColumn('relationship_id', 'relationship');
           $table->dropColumn('other_relationship');
        });
    }
};
