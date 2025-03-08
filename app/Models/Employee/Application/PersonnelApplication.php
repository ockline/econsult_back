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
        'id_type',
        'new_job_title_id',
        'new_department_id',
        'effective_date',
        'supervisor_name',
        'safety_induction',
        'emergency_contact_name',
        'emergency_contact_number',
        'manager_name',
        'approval_date',
        'signature',
        'training_hr_manager',
        'course_study',
        'institution_name',
        'security_officer',
        'host_name',
        'contact_number',
        'organization',
        'position',
        'email_address',
        'phone_number',
        'contact_person',
        'employee_no',
'nida_passport_doc'

    ];
}
