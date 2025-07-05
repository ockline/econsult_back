<?php

namespace App\Models\IndustrialRelationship\Disciplinary;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class AppealDisciplinary extends Model
{
    use Auditable;

    protected $table = 'disciplinary_appeals';

    public $timestamps = true;
    protected $fillable = [
        'disciplinary_id',
        'comments',
        'count',
        'is_notice_appeal',
        'appeal_date',
        'is_employee_appeal',
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

    ];

    protected $guarded = [];
}
