<?php

namespace App\Models\IndustrialRelationship\Disciplinary;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Disciplinary extends Model
{
    use Auditable;

    protected $table = 'disciplinaries';

    public $timestamps = true;
    protected $fillable = [
        'employee_id',
        'employer_id',
        'misconduct_id',
        'remarks',
        'count',
        'is_charge_sheet',
        'is_notice_appeal',
        'is_employee_notified',
        'employee_notification_date',
        'is_employee_appeal',
        'appeal_date',
        'status',
        'stage',
        'initiated_by',
        'initiated_date',
        'decision_released_date',
        'source',
        'created_at',
        'updated_at',
        'deleted_at',
        'modified_by',
        'modified_date',
        'issue_charge_sheet_date'

    ];

    protected $guarded = [];
}
