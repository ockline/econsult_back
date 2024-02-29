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
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'driving_licence')) {
                 DB::statement('ALTER TABLE employees ALTER COLUMN driving_licence TYPE INTEGER USING driving_licence::INTEGER');
            }
        });

        // If the above change does not work, you can try using the USING clause
        // Uncomment the lines below and comment out the $table->integer('driving_licence')->change();
        /*
        DB::statement('ALTER TABLE employees ALTER COLUMN driving_licence TYPE INTEGER USING driving_licence::INTEGER');
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('driving_licence');
        });
    }
};
