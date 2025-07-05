<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE audits ALTER COLUMN auditable_type TYPE VARCHAR(255) USING auditable_type::VARCHAR(255);');
    }

    public function down()
    {
        // Optional: revert to integer if necessary
        DB::statement('ALTER TABLE audits ALTER COLUMN auditable_type TYPE INTEGER USING auditable_type::INTEGER;');
    }
};
