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
     public function up()
    {
        // For PostgreSQL, changing types can require using raw SQL
        DB::statement('ALTER TABLE audits ALTER COLUMN event TYPE VARCHAR(255) USING event::VARCHAR(255);');
    }

    public function down()
    {
        // Optional: revert back to integer if needed
        DB::statement('ALTER TABLE audits ALTER COLUMN event TYPE INTEGER USING event::INTEGER;');
    }
};
