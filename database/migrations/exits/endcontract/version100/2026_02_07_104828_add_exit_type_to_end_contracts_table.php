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
        Schema::table('end_contracts', function (Blueprint $table) {
            // Add exit_type column to distinguish between different exit types
            // Values: 'end_contract' (Fixed Term), 'end_specific_contract' (Specific Task), 'resignation', 'retrenchment', 'mutual_agreement'
            $table->enum('exit_type', ['end_contract', 'end_specific_contract', 'resignation', 'retrenchment', 'mutual_agreement'])
                  ->default('end_contract')
                  ->after('employee_id');
            
            // Add contract_type_id to link to the contracts table (1 = Fixed Term, 2 = Specific Task)
            $table->unsignedBigInteger('contract_type_id')->nullable()->after('exit_type');
            
            // Add index for better query performance
            $table->index('exit_type');
            $table->index('contract_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('end_contracts', function (Blueprint $table) {
            $table->dropIndex(['exit_type']);
            $table->dropIndex(['contract_type_id']);
            $table->dropColumn(['exit_type', 'contract_type_id']);
        });
    }
};
