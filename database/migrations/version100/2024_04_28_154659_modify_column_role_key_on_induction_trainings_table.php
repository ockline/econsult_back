<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modify the existing column (if it exists)
        if (Schema::hasColumn('induction_trainings', 'roles_key')) {
            Schema::table('induction_trainings', function (Blueprint $table) {
                $table->text('roles_key')->nullable()->change();
            });
        } else {
            // Handle if the column doesn't exist
            // You can either create the column or handle the migration in another way
            // For example, you might need to create the column first and then modify it
            // Or you might need to perform a different action based on your requirements
            // For now, I'll leave this block empty
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback the changes made in the up() method
        if (Schema::hasColumn('induction_trainings', 'roles_key')) {
            Schema::table('induction_trainings', function (Blueprint $table) {
                $table->text('roles_key')->nullable(false)->change();
            });
        }
    }
};
