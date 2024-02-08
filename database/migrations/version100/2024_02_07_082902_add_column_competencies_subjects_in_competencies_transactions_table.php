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
        Schema::table('competencies_transactions', function (Blueprint $table) {
                $table->integer('competency_interview_id');
                $table->integer('interactive_communication');
                $table->integer('accountability');
                $table->integer('work_excellence');
                $table->integer('planning_organizing');
                $table->integer('problem_solving');
                $table->integer('analytical_ability');
                $table->integer('attention_Details');
                $table->integer('initiative');
                $table->integer('multi_tasking');
                $table->integer('continuous_improvement');
                $table->integer('compliance');
                $table->integer('creativity_innovation');
                $table->integer('negotiation');
                $table->integer('team_work');
                $table->integer('adaptability_flexibility');
                $table->integer('leadership');
                $table->integer('delegating_managing');
                $table->integer('managing_change');
                $table->integer('strategic_conceptual_thinking');
                $table->text('interactive_communication_remark')->nullable();
                $table->text('accountability_remark')->nullable();
                $table->text('work_excellence_remark')->nullable();
                $table->text('planning_organizing_remark')->nullable();
                $table->text('problem_solving_remark')->nullable();
                $table->text('analytical_ability_remark')->nullable();
                $table->text('attention_Details_remark')->nullable();
                $table->text('initiative_remark')->nullable();
                $table->text('multi_tasking_remark')->nullable();
                $table->text('continuous_improvement_remark')->nullable();
                $table->text('compliance_remark')->nullable();
                $table->text('creativity_innovation_remark')->nullable();
                $table->text('negotiation_remark')->nullable();
                $table->text('team_work_remark')->nullable();
                $table->text('adaptability_flexibility_remark')->nullable();
                $table->text('leadership_remark')->nullable();
                $table->text('delegating_managing_remark')->nullable();
                $table->text('managing_change_remark')->nullable();
                $table->text('strategic_conceptual_thinking_remark')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competencies_transactions', function (Blueprint $table) {
                $table->dropColumn('competency_interview_id');
                $table->dropColumn('interactive_communication');
                $table->dropColumn('accountability');
                $table->dropColumn('work_excellence');
                $table->dropColumn('planning_organizing');
                $table->dropColumn('problem_solving');
                $table->dropColumn('analytical_ability');
                $table->dropColumn('attention_Details');
                $table->dropColumn('initiative');
                $table->dropColumn('multi_tasking');
                $table->dropColumn('continuous_improvement');
                $table->dropColumn('compliance');
                $table->dropColumn('creativity_innovation');
                $table->dropColumn('negotiation');
                $table->dropColumn('team_work');
                $table->dropColumn('adaptability_flexibility');
                $table->dropColumn('leadership');
                $table->dropColumn('delegating_managing');
                $table->dropColumn('managing_change');
                $table->dropColumn('strategic_conceptual_thinking');
                $table->dropColumn('interactive_communication_remark');
                $table->dropColumn('accountability_remark');
                $table->dropColumn('work_excellence_remark');
                $table->dropColumn('planning_organizing_remark');
                $table->dropColumn('problem_solving_remark');
                $table->dropColumn('analytical_ability_remark');
                $table->dropColumn('attention_Details_remark');
                $table->dropColumn('initiative_remark');
                $table->dropColumn('multi_tasking_remark');
                $table->dropColumn('continuous_improvement_remark');
                $table->dropColumn('compliance_remark');
                $table->dropColumn('creativity_innovation_remark');
                $table->dropColumn('negotiation_remark');
                $table->dropColumn('team_work_remark');
                $table->dropColumn('adaptability_flexibility_remark');
                $table->dropColumn('leadership_remark');
                $table->dropColumn('delegating_managing_remark');
                $table->dropColumn('managing_change_remark');
                $table->dropColumn('strategic_conceptual_thinking_remark');

        });
    }
};
