<?php

namespace App\Models\IndustrialRelationship\Misconduct;

use Illuminate\Database\Eloquent\Model;

class Misconduct extends Model {


        protected $table = 'misconducts';

    public $timestamps = true;
    protected $fillable = [
	'misconduct_cause',
        'employee_id',
        'employer_id',
        'misconduct_date',
        'employee_name',
        'investigation_report',
        'dismiss_remarks',
        'dismiss_date',
        'investigation_report_attachment',
        'show_cause_letter',
        'status',
        'stage',
        'count'
    ];
    protected $guarded = [];

}