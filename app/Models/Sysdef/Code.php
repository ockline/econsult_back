<?php

namespace App\Models\Sysdef;


use App\Models\Sysdef\Traits\Attribute\CodeAttribute;
use App\Models\Sysdef\Traits\Relationship\CodeRelationship;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * package App.
 */
class Code extends Model
{

use CodeAttribute,CodeRelationship;

    /**
     * @var array
     */
    protected $guarded = [];





}
