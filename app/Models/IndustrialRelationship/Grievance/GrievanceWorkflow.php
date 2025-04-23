<?php

namespace App\Models\IndustrialRelationship\Grievance;

use Illuminate\Database\Eloquent\Model;

class GrievanceWorkflow extends Model
{


    protected $table = 's';

    public $timestamps = true;
    protected $fillable = [
    'grievance_id',
    'user_id',
    'parent_id',
    'status',
    'comments',
    'stage',
    'reamrk', // If this is a typo, change to 'remark'
    'action_taken',
    'recommendation',
    'result',
    'received_date',
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




























