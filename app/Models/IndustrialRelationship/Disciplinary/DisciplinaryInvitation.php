<?php

namespace App\Models\IndustrialRelationship\Disciplinary;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryInvitation extends Model
{
    use Auditable;

    protected $table = 'disciplinary_invitations';

    public $timestamps = true;
    protected $fillable = [
        'employee_id',
        'disciplinary_id',
        'remarks',
        'count',
        'hearing_date',
        'hearing_time',
        'hearing_venue',
        'hearing_location',
        'rescheduled_date',
        'status',
        'stage',
        'initiated_by',
        'initiated_date',
        'postpone_reason',
        'pospone_date',
        'source',
        'created_at',
        'updated_at',
        'deleted_at',
        'modified_by',
        'modified_date',
    ];

    protected $guarded = [];
}
