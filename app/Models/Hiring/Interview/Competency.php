<?php

namespace App\Models\Hiring\Interview;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
        use Auditable;
    protected  $table = 'competencies';
    protected $guarded = [];
    public $timestamps = true;
}
