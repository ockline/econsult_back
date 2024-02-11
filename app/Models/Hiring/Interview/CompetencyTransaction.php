<?php

namespace App\Models\Hiring\Interview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyTransaction extends Model
{
   use SoftDeletes;

    protected  $table = 'competencies_transactions';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'competency_id','competency__subject_id','description','competency_interview_id','interactive_communication', 'accountability', 'work_excellence', 'planning_organizing', 'problem_solving', 'analytical_ability', 'attention_details', 'initiative', 'multi_tasking', 'continuous_improvement', 'compliance', 'creativity_innovation', 'negotiation', 'team_work', 'adaptability_flexibility', 'leadership', 'delegating_managing', 'managing_change', 'strategic_conceptual_thinking', 'interactive_communication_remark', 'accountability_remark', 'work_excellence_remark', 'planning_organizing_remark', 'problem_solving_remark', 'analytical_ability_remark', 'attention_details_remark', 'initiative_remark', 'multi_tasking_remark', 'continuous_improvement_remark', 'compliance_remark', 'creativity_innovation_remark', 'negotiation_remark', 'team_work_remark', 'adaptability_flexibility_remark', 'leadership_remark', 'delegating_managing_remark', 'managing_change_remark', 'strategic_conceptual_thinking_remark',
    ];

  public function toJson($options = 0)
    {
        // Check if you have overridden the toJson method
        // Ensure it doesn't create a recursion issue
        // Remove or adjust this method if necessary
        return parent::toJson($options);
    }

}
