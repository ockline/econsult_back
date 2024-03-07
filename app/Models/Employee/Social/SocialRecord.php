<?php

namespace App\Models\Employee\Social;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialRecord extends Model
{
    use SoftDeletes;

    protected  $table = 'social_records';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
'employee_id',
'district_id',
'department_id',
'section',
'firstname',
'middlename',
'lastname',
'national_id',
'expiration_date',
'passport_id',
'military_service',
'marital_status',
'children_no',
'gender',
'telephone_home',
'mobile_number',
'person_email',
'city_id',
'ward_id',
'employee_street',
'postal_address',
'relative_working',
'relative_name',
'tin',
'remark',
'downloaded',
'uploaded',
'uploaded_date',
'stage',
'progressive_stage',
'status',

    ];
}
