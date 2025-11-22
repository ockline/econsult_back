<?php

namespace App\Models\Workflow;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class PerformanceReviewWorkflow extends Authenticatable
{
    use Notifiable, SoftDeletes,Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
        protected $table = 'performance_review_workflows';

   protected $fillable = [
    'user_id',
    'parent_id',
    'status',
    'received_date',
    'current_stage',
    'attended_date',
    'attended_by',
    'previous_stage',
    'function_name',
    'deleted_by',
    'comments',
    'review_id',
    'return_to_user_id',
    'return_to_user_name',
];

 protected $guarded = [];

}
