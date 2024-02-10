<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // In the up() method
public function up()
{
    Schema::table('competency_interviews', function (Blueprint $table) {
        $table->integer('current_employed_entity')
              ->comment('1 - Private sector, 2- Public Sector, 3 - N/A')
              ->default(3);
    });
}

// In the down() method
public function down()
{
    Schema::table('competency_interviews', function (Blueprint $table) {
        $table->dropColumn('current_employed_entity');
    });
}

};
