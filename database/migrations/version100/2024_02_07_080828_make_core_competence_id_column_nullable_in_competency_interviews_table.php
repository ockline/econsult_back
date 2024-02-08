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
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->integer('core_competence_id')->nullable()->change();
            $table->integer('functional_competence_id')->nullable()->change();
            $table->integer('mgt_senior_competence_id')->nullable()->change();
            $table->integer('mgt_top_competence_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->integer('core_competence_id')->nullable(false)->change();
            $table->integer('functional_competence_id')->nullable(false)->change();
            $table->integer('mgt_senior_competence_id')->nullable(false)->change();
            $table->integer('mgt_top_competence_id')->nullable(false)->change();
        });
    }
};
