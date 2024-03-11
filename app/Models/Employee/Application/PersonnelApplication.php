<?php

namespace App\Models\Employee\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonnelApplication extends Model
{
    use SoftDeletes;

    protected  $table = 'employee_identifications';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'employer_id',
        'department_id',
        'section',
        'firstname',
        'middlename',
        'lastname',
        'national_id',
        'personal_type',
        'downloaded',
        'uploaded',
        'stage',
        'progressive_stage',
        'status',
        'transfer_from',
        'site_pass_type',
        'from_date',
        'end_date',
        'national_id_uploaded',
        'practical_uploaded',
        'technical_uploaded',
        'driving_licence_uploaded',
        'uploaded_date',
        'duration_deployment',
        'birth_place',
        'job_title_id',
        'purpose',

    ];
}
