<?php

namespace App\Models\IndustrialRelationship\PerformanceCapacity;

use Illuminate\Database\Eloquent\Model;

class PerformanceAssessment extends Model
{


    protected $table = 'performance_assessments';

    public $timestamps = true;
protected $fillable = [
        'incapacity_type',
        'employee_id',
        'investigation_report',
        'investigation_date',
        'investigation_time',
        'subject_matter',
        'investigator_name',
        'investigator_signature',
        'investigator_designation',
        'suffering_from',
        'suffering_period',
        'daily_duties',
        'challenge_daily_duties',
        'alternative_task',
        'partient_suggestion',
        'capacity_id',
        'sequence',
        'illness_cause',
        'illness_degree',
        'occupation_illness',
        'occupation_justification',
        'possible_nature_illness',
        'permanent_alternative_activity',
        'total_recovery_activity',
        'suggested_task',
        'measure_taken',
        'assessor_recommendation',
        'assessor_name',
        'assessor_designation',
        'assessmnet_date',
        'assessor_signature',
        'assessment_signed_attchment',
       
    ];

    protected $guarded = [];
}
