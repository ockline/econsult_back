<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = true;

protected $fillable  = ['employee_id', 'employer_id', 'firstname', 'middlename', 'lastname', 'shift', 'time_in', 'time_out', 'date', 'remarks','public_holiday','employee_name'
];
}

