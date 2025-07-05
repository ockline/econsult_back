<?php

namespace App\Models\IndustrialRelationship\Grievance;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    use Auditable;

    protected $table = 'grievances';

    public $timestamps = true;
    protected $fillable = [
        'employee_id',
        'employer_id',
        'grievance_reason',
        'grievance_resolution',
        'report_date',
        'resolution_date',
        'status',
        'stage',
        'initiated_by',
        'initiated_date',
        'source',
        'created_at',
        'updated_at',
        'deleted_at',
        'modified_by',
        'modified_date',
        'resolution'
    ];

    protected $guarded = [];
}
