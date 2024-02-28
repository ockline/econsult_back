<?php

namespace App\Models\Employee\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeEducation extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employee_education_hist';

    protected $fillable = [
         'employee_id','education_id','institute_name','description','other_institute','major','course','graduation_year'
    ];


}
