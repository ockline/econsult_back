<?php

namespace App\Models\ContractManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedContract extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'contract_fixed';
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
        'job_profile',
        'reporting_to',
        'staff_classfication',
        'place_recruitment',
        'work_station',
        'commencement_date',
        'end_commencement_date',
        'probation_period',
        'remuneration',
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
        'covered_statutory',
        'downloaded',
        'uploaded',
        'uploaded_date',
        'stage',
        'progressive_stage',
        'status',

    ];
}
