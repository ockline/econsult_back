<?php

namespace App\Models\Employee\Personal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmploymentReference extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employee_reference_check';

    protected $fillable = [
         'employee_id','referee_id','referee_name','referee_title','referee_address','referee_contact','referee_email','description'
    ];


}
