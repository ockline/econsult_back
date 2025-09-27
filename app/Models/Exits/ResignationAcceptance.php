<?php

namespace App\Models\Exits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResignationAcceptance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resignation_acceptances';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'resignation_id',
        'acceptance_date',
        'employee_name',
        'job_title',
        'postal_address',
        'letter_dated',
        'service_of',
        'effective_from',
        'started_work',
        'hr_name',
        'hr_designation',
        'hr_signature_file',
        'employee_signature_file',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'acceptance_date' => 'date',
        'letter_dated' => 'date',
        'effective_from' => 'date',
        'started_work' => 'date',
    ];

    /**
     * Get the resignation that owns the acceptance.
     */
    public function resignation()
    {
        return $this->belongsTo(Resignation::class);
    }

    /**
     * Get the user who created the acceptance.
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Get the user who last updated the acceptance.
     */
    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
