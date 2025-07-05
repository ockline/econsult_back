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
        DB::statement('ALTER TABLE audits ALTER COLUMN user_type DROP NOT NULL;');
    }

    public function down()
    {
        // Optional: revert if needed
        DB::statement('ALTER TABLE audits ALTER COLUMN user_type SET NOT NULL;');
    }
};
