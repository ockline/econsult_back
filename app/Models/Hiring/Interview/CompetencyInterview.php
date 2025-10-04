<?php

namespace App\Models\Hiring\Interview;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyInterview extends Model
{
  use SoftDeletes, Auditable;

    protected  $table = 'competency_interviews';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'job_title_id','cost_center_id','cost_number','date','firstname', 'middlename', 'lastname','interviewer','military_service', 'military_number', 'place_recruitment','year_experience','education_knowledge', 'relevant_experience','major_achievement',
        'language_fluency_id','education_knowledge_remark', 'relevant_experience_remark','major_achievement_remark',   'language_fluency_remark','overall_rating','main_strength','main_weakness', 'birth_place', 'residence_place','relative_inside','relative_name', 'chronic_disease','chronic_remarks','pregnant','pregnancy_months','employed_before','reference_check',
        'reference_remarks','current_packages','agreed_salary','required_notes','current_employed_entity','social_insuarance_status',
        'work_site', 'reallocation_place','recruiter_recommendations','recommended_title','interview_number','candidate_name','ranking_creterial_id','core_competence_id','core_remark','functional_competence_id','functional_remark','status','mgt_senior_competence_id','mgt_senior_remark','mgt_top_competence_id','mgt_top_remark','downloaded','uploaded','surgery_operation','uploaded_date','surgery_operation_remark'

    ];
}
