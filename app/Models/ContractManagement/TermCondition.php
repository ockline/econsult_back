<?php

namespace App\Models\ContractManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TermCondition extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'contract_term_conditions';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'employer_name',
        'reg_number',
        'employee_name',
        'job_title_id',
        'department_id',
        'date_contracted',
        'downloaded',
        'uploaded',
        'uploaded_date',
        'stage',
        'progressive_stage',
        'supportive_attachment'

    ];
}
