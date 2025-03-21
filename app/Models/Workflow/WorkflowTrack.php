<?php

namespace App\Models\Workflow;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class WorkflowTrack extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
        protected $table = 'workflow_tracks';

   protected $fillable = [
    'user_id', 'model_type', 'status', 'created_date', 'received_date', 'created_date', 'attended_date', 'attended_by', 'level', 'stage',  'created_by',
];

}
