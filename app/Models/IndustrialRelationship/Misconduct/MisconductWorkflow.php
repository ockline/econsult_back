<?php

namespace App\Models\IndustrialRelationship\Misconduct;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class MisconductWorkflow extends Model
{
    use Auditable;

    protected $table = 'misconduct_workflows';

    public $timestamps = true;
    protected $fillable = [
    'misconduct_id',
    'user_id',
    'parent_id',
    'status',
    'comments',
    'stage',
    'case_decision',
    'action_taken',
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




























