<?php

namespace App\Models\IndustrialRelationship\Disciplinary;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisciplinaryInvitee extends Model
{
    use SoftDeletes, Auditable;

    protected $table = 'disciplinary_invitees';

    protected $fillable = [
        'invitation_id',
        'invitation_type',
        'invitee_name',
        'designation',
        'invitation_date',
        'invited_by',
    ];
}
