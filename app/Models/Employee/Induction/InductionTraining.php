<?php

namespace App\Models\Employee\Induction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InductionTraining extends Model
{
    use SoftDeletes;

    protected  $table = 'induction_trainings';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [

'social_record_id',
'employer_id',
'employer_address',
'contact_personal',
'job_title_id',
'personal_contacts',
'personal_designation',
'firstname',
'middlename',
'lastname',
'department_id',
'reporting_to',
'business',
'employment_date',
'establishment',
'roles_key',
'employee_remuneration',
'employment_condition',
'environment',
'apropos_training',
'health_safety',
'conduct_follow_up',
'comments',
'notes',
'conducted_by',
'conducted_date',
'declaration',
'downloaded',
'uploaded',
'uploaded_date',
'stage',
'progressive_stage',
'status',
'created_at',
'updated_at',
'deleted_at'

    ];

}


