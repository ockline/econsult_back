<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Model;

class AllLeave extends Model {


        protected $table = 'leaves';

    public $timestamps = true;
    protected $fillable = [
	'leave_type_id','employer_id','employee_id', 'balance_days', 'financial_year', 'all_balance', 'start_date', 'end_date', 'status', 'remarks', 'refferal_to','age','hospital_name'
    ];
    protected $guarded = [];

}
