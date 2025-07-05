<?php

namespace App\Models\Hiring\Interview;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class CompetencySubject extends Model
{
 use Auditable;
    protected  $table = 'competencies_subjects';
    protected $guarded = [];
    public $timestamps = true;
}
