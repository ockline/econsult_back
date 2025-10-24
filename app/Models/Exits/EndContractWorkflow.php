<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class EndContractWorkflow extends Model
{
    use HasFactory;

    protected $table = 'end_contract_workflows';

    protected $fillable = [
        'end_contract_id',
        'comments',
        'recommendation',
        'received_date',
        'attended_by',
        'attended_date',
        'status',
        'stage',
        'function_name',
        'previous_stage',
        'next_stage'
    ];

    protected $dates = [
        'received_date',
        'attended_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'received_date' => 'datetime',
        'attended_date' => 'datetime'
    ];

    /**
     * Get the end contract that owns the workflow
     */
    public function endContract()
    {
        return $this->belongsTo(EndContract::class, 'end_contract_id');
    }

    /**
     * Get the user who attended to this workflow step
     */
    public function attendedBy()
    {
        return $this->belongsTo(User::class, 'attended_by');
    }

    /**
     * Scope to filter by end contract
     */
    public function scopeByEndContract($query, $endContractId)
    {
        return $query->where('end_contract_id', $endContractId);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by stage
     */
    public function scopeByStage($query, $stage)
    {
        return $query->where('stage', $stage);
    }

    /**
     * Scope to filter by attended user
     */
    public function scopeByAttendedBy($query, $userId)
    {
        return $query->where('attended_by', $userId);
    }

    /**
     * Scope to order by date
     */
    public function scopeOrderByDate($query, $direction = 'asc')
    {
        return $query->orderBy('attended_date', $direction);
    }

    /**
     * Get the status color for UI
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'Initiated' => 'primary',
            'Reviewed' => 'info',
            'Approved' => 'success',
            'Rejected' => 'error',
            'Returned' => 'warning'
        ];

        return $colors[$this->status] ?? 'default';
    }
}
