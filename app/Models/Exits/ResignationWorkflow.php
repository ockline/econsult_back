<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResignationWorkflow extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resignation_workflows';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'resignation_id',
        'parent_id',
        'comments',
        'report_date',
        'received_date',
        'action_taken',
        'recommendation',
        'result',
        'attended_by',
        'attended_date',
        'status',
        'stage',
        'function_name',
        'previous_stage',
        'next_stage',
    ];

    protected $casts = [
        'report_date' => 'date',
        'received_date' => 'date',
        'attended_date' => 'date',
    ];

    /**
     * Get the resignation that owns the workflow.
     */
    public function resignation()
    {
        return $this->belongsTo(Resignation::class);
    }

    /**
     * Get the parent workflow.
     */
    public function parent()
    {
        return $this->belongsTo(ResignationWorkflow::class, 'parent_id');
    }

    /**
     * Get the child workflows.
     */
    public function children()
    {
        return $this->hasMany(ResignationWorkflow::class, 'parent_id');
    }

    /**
     * Get the user who attended this workflow step.
     */
    public function attendedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'attended_by');
    }
}
