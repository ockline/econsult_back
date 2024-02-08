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
            $table->text('education_knowledge_remark')->nullable();
            $table->text('relevant_experience_remark')->nullable();
            $table->text('major_achievement_remark')->nullable();
            $table->text('language_fluency_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competency_interviews', function (Blueprint $table) {
         $table->dropColumn('education_knowledge_remark');
            $table->dropColumn('relevant_experience_remark');
            $table->dropColumn('major_achievement_remark');
            $table->dropColumn('language_fluency_remark');
        });
    }
};
