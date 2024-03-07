<?php

namespace App\Models\Employee\Social;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelativeDetail extends Model
{
    use SoftDeletes;

    protected  $table = 'employee_reletives';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'relative_id',
        'relative_number',
        'other_relationship',
        'relationship_id',
        'description',
        'social_record_id',
        'relative_address',
        'relative_name',

    ];
}
