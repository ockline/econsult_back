<?php

namespace App\Models\Employee\Social;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependant extends Model
{
    use SoftDeletes;

    protected  $table = 'dependants';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'social_record_id',
        'dependent_id',
        'other_relationship',
        'description',
        'relationship',
        'dob',
        'dependant_type_id',
        'dependant_name',

    ];
}
