<?php

namespace App\Models\ContractManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecificTask extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'contract_specific';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'name',
        'employer_name',
        'employee_name',
        'job_title_id',
        'phone_number',
        'email',
        'dob',
        'reg_number',
        'place_recruitment',
        'work_station',
        'basic_salary',
        'house_allowance',
        'meal_allowance',
        'transport_allowance',
        'risk_bush_allowance',
        'normal_working',
        'ordinary_working',
        'working_from',
        'working_to',
        'saturday_from',
        'saturday_to',
        'department_id',
       'bank_name',
       'bank_account_no',
       'bank_account_name',
        'residence_place',
        'nssf_number',
        'gender',
        'supervisor',
        'start_date',
        'expected_end_date',
        'monthly_salary',
        'night_shift',
        'night_working_from',
        'night_working_to',
        'night_shift_hours',
        'downloaded',
        'uploaded',
        'uploaded_date',
        'stage',
        'progressive_stage',
        'status',

    ];
}




