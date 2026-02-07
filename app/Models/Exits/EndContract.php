<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Employee\Personal\Employee;

class EndContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'end_contracts';

    protected $fillable = [
        'employee_id',
        'exit_type',
        'contract_type_id',
        'employee_name',
        'department_name',
        'job_title',
        'postal_address',
        'phone_number',
        'remark',
        'end_date',
        'renewal_notice_file',
        'employer_name',
        'letter_title',
        'signed_date',
        'started_date',
        'days_worked',
        'on_behalf_of',
        'designation',
        'hr_name',
        'signature_file',
        'employee_designation',
        'employee_signature_file',
        'job_department',
        'contract_date',
        'expire_date',
        'non_renewal_letter_title',
        'status',
        'stage',
        'hr_recommendations',
        'manager_recommendations',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'end_date',
        'signed_date',
        'started_date',
        'contract_date',
        'expire_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'end_date' => 'date',
        'signed_date' => 'date',
        'started_date' => 'date',
        'contract_date' => 'date',
        'expire_date' => 'date',
        'days_worked' => 'integer'
    ];

    /**
     * Get the employee that owns the end contract
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the user who created the end contract
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the end contract
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the workflows for the end contract
     */
    public function workflows()
    {
        return $this->hasMany(EndContractWorkflow::class, 'end_contract_id');
    }

    /**
     * Get the latest workflow entry
     */
    public function latestWorkflow()
    {
        return $this->hasOne(EndContractWorkflow::class, 'end_contract_id')->latest();
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
     * Scope to filter by employee
     */
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('end_date', [$startDate, $endDate]);
    }

    /**
     * Get the status color for UI
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'Draft' => 'warning',
            'Submitted' => 'processing',
            'Under Review' => 'info',
            'Approved' => 'success',
            'Rejected' => 'error',
            'Completed' => 'success'
        ];

        return $colors[$this->status] ?? 'default';
    }

    /**
     * Get the stage color for UI
     */
    public function getStageColorAttribute()
    {
        $colors = [
            'Initiated' => 'default',
            'HR Review' => 'processing',
            'Manager Review' => 'warning',
            'Final Approval' => 'success',
            'Completed' => 'success'
        ];

        return $colors[$this->stage] ?? 'default';
    }

    /**
     * Check if the end contract can be edited
     */
    public function canBeEdited()
    {
        return $this->status === 'Draft';
    }

    /**
     * Check if the end contract can be deleted
     */
    public function canBeDeleted()
    {
        return $this->status === 'Draft';
    }

    /**
     * Check if the end contract can be submitted
     */
    public function canBeSubmitted()
    {
        return $this->status === 'Draft';
    }

    /**
     * Check if contracts can be generated
     */
    public function canGenerateContracts()
    {
        return in_array($this->status, ['Approved', 'Completed']);
    }
}
