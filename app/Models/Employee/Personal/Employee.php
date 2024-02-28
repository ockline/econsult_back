<?php

namespace App\Models\Employee\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected  $table = 'employees';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'job_title_id',
        'cost_center_id',
        'cost_number',
        'firstname',
        'middlename',
        'lastname',
        'employee_no',
        'employee_name',
        'interview_number',
        'military_service',
        'military_number',
        'name_language',
        'gender',
        'package_id',
        'department_id',
        'national_id',
        'passport_id',
        'marital_status',
        'spause_name',
        'telephone_home',
        'telephone_office',
        'mobile_number',
        'email',
        'dob',
        'nationality_id',
        'driving_licence',
        'place_issued',
        'chronic_disease',
        'chronic_remark',
        'surgery_operation',
        'surgery_remark',
        'employed_before',
        'from_date',
        'to_date',
        'position',
        'relative_working',
        'relative_name',
        'former_department',
        'transfer_change',
        'transfer_reasons',
        'bank_id',
        'account_number',
        'bank_branch_id',
        'account_name',
        'nssf',
        'wcf',
        'tin',
        'nhif',
        'company_name',
        'employer_from_date',
        'employer_to_date',
        'readiness_employee',
        'downloaded',
        'uploaded',
        'uploaded_date',
        'stage',
        'progressive_stage',
        'status',

    ];
}
