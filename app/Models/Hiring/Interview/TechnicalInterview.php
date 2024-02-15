<?php

namespace App\Models\Hiring\Interview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicalInterview extends Model
{
  use SoftDeletes;

    protected  $table = 'technical_interviews';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'job_title_id','cost_center_id','cost_number','date','firstname', 'middlename', 'lastname','interviewer','technical_skill', 'relevant_experience','knowledge_equipment','quality_awareness','skill_remark', 'experience_remark','equipment_remark','awareness_remark','overall_rating','physical_capability','capability_remark','practical_test_id', 'final_recommendation', 'employer_id','recommended_title','interview_number','candidate_name','ranking_creterial_id','status','downloaded','uploaded','uploaded_date'
    ];
}
