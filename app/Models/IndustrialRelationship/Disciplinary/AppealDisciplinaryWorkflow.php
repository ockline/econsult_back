<?php

namespace App\Models\IndustrialRelationship\Disciplinary;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class AppealDisciplinaryWorkflow extends Model
{
    use Auditable;

    protected $table = 'disciplinary_appeal_workflows';

    public $timestamps = true;
    protected $fillable = [
        'appeal_id',
        'user_id',
        'parent_id',
        'status',
        'comments',
        'stage',
        'appeal_outcome',
        'attended_by',
        'attended_date',
        'function_name',
        'previous_stage',
        'next_stage',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];
}
