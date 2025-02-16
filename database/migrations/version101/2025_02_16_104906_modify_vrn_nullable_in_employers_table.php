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
        Schema::table('employers', function (Blueprint $table) {
            $table->integer('vrn')->nullable()->change();
          $table->integer('wcf')->nullable()->change();
          $table->integer('nhif')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employers', function (Blueprint $table) {
           
            $table->integer('vrn')->nullable(false)->change();
          $table->integer('wcf')->nullable(false)->change();
            $table->integer('nhif')->nullable(false)->change();
            });
    }
};
