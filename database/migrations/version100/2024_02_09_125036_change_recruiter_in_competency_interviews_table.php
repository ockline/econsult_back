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
        // Add a new integer column
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->integer('new_recruiter_recommendations')
                  ->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List')
                  ->default(null);
        });

        // Update the new column based on the values of the old boolean column
        DB::table('competency_interviews')->update([
            'new_recruiter_recommendations' => DB::raw('CASE WHEN recruiter_recommendations = true THEN 1 WHEN recruiter_recommendations = false THEN 2 ELSE 3 END'),
        ]);

        // Remove the old boolean column
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->dropColumn('recruiter_recommendations');
        });

        // Rename the new integer column to the original name
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->renameColumn('new_recruiter_recommendations', 'recruiter_recommendations');
        });
    }

    public function down()
    {
        // Revert the changes in case of rollback
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->boolean('recruiter_recommendations')
                  ->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List')
                  ->default(false);
        });
    }
};
