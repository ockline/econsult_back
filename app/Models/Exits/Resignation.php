<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee\Personal\Employee;

class Resignation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resignations';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'department_name',
        'job_title',
        'postal_address',
        'phone_number',
        'remark',
        'resignation_date',
        'resignation_notice_file',
        'resignation_form_file',
        'resignation_letter_file',
        'certificate_of_service_file',
        'status',
        'stage',
        'hr_recommendations',
        'manager_recommendations',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'resignation_date' => 'date',
    ];

    /**
     * Get the employee that owns the resignation.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the resignation acceptance details.
     */
    public function acceptance()
    {
        return $this->hasOne(ResignationAcceptance::class);
    }

    /**
     * Get the resignation workflows.
     */
    public function workflows()
    {
        return $this->hasMany(ResignationWorkflow::class);
    }

    /**
     * Get the resignation attachments.
     */
    public function attachments()
    {
        return $this->hasMany(ResignationAttachment::class);
    }

    /**
     * Get the user who created the resignation.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Get the user who last updated the resignation.
     */
    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
