<?php

namespace App\Models\IndustrialRelationship\Misconduct;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Misconduct extends Model
{
    use Auditable;

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
        'count',
        'incidence_remarks',
        'incidence_reported_by',
        'incidence_reported_date',
        'initiated_by',
        'initiated_date'
    ];
    protected $guarded = [];
}
