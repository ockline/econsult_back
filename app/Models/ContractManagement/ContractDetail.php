<?php

namespace App\Models\ContractManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContractDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected  $table = 'contract_details';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'contract_id',
        'employer_id',
        'job_title_id',
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'phone_number',
        'email',
        'dob',
        'age',
        'postal_address',
        'residence_place',
        'permanent_residence',
        'place_recruitment',
        'work_station',
        'date_employed',
        'fullname_next1',
        'residence1',
        'phone_number1',
        'relationship1',
        'fullname_next2',
        'residence2',
        'phone_number2',
        'relationship2',
        'downloaded',
        'uploaded',
        'uploaded_date',
        'stage',
        'progressive_stage',
        'passport_attachment',
        'birth_place'

    ];
}
