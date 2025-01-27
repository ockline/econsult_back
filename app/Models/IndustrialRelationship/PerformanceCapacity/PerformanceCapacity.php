<?php

namespace App\Models\IndustrialRelationship\PerformanceCapacity;

use Illuminate\Database\Eloquent\Model;

class PerformanceCapacity extends Model
{


    protected $table = 'performance_capacities';

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
    ];

    protected $guarded = [];
}
