<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

class OverTime extends Model
{
    protected $table = 'overtimes';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable  = ['employee_id', 'employer_id', 'firstname', 'middlename', 'lastname', 'shift', 'time_in', 'time_out', 'date', 'remarks','public_holiday','employee_name', 'overtime_date', 'ot_hours'
];
}
