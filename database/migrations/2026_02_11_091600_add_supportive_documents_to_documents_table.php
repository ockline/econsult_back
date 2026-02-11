<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds supportive document types: Fitness to Work Declaration, Tax Identification Number, Consent Letter.
     * Fixes: Foreign key violation - document_id 65, 66, 67 must exist in documents table.
     */
    public function up(): void
    {
        $now = now()->format('Y-m-d H:i:s');
        $rows = [
            [
                'id' => 65,
                'name' => 'Fitness to Work Declaration',
                'document_group_id' => 7,
                'description' => 'fitness_to_work_declaration',
                'isrecurring' => 0,
                'ismandatory' => 1,
                'isactive' => 1,
                'created_at' => $now,
                'updated_at' => null,
                'deleted_at' => null,
                'anysource' => 1,
                'isother' => 0,
                'document_order' => null,
            ],
            [
                'id' => 66,
                'name' => 'Tax Identification Number',
                'document_group_id' => 7,
                'description' => 'tax_identification_number',
                'isrecurring' => 0,
                'ismandatory' => 1,
                'isactive' => 1,
                'created_at' => $now,
                'updated_at' => null,
                'deleted_at' => null,
                'anysource' => 1,
                'isother' => 0,
                'document_order' => null,
            ],
            [
                'id' => 67,
                'name' => 'Consent Letter',
                'document_group_id' => 7,
                'description' => 'consent_letter',
                'isrecurring' => 0,
                'ismandatory' => 1,
                'isactive' => 1,
                'created_at' => $now,
                'updated_at' => null,
                'deleted_at' => null,
                'anysource' => 1,
                'isother' => 0,
                'document_order' => null,
            ],
        ];

        foreach ($rows as $row) {
            if (DB::table('documents')->where('id', $row['id'])->exists()) {
                continue;
            }
            DB::table('documents')->insert($row);
        }

        // Ensure PostgreSQL sequence is ahead of inserted ids (avoids duplicate key on next insert)
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement("SELECT setval(pg_get_serial_sequence('documents', 'id'), (SELECT COALESCE(MAX(id), 1) FROM documents))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('employee_documents')->whereIn('document_id', [65, 66, 67])->delete();
        DB::table('documents')->whereIn('id', [65, 66, 67])->delete();
    }
};
