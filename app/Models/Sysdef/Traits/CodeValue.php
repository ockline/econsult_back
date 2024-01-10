<?php

namespace App\Models\Sysdef;

use App\Models\Sysdef\Traits\Attribute\CodeValueAttribute;
use App\Models\Sysdef\Traits\Relationship\CodeValueRelationship;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * package App.
 */
class CodeValue extends Model
{

    use CodeValueAttribute,CodeValueRelationship;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgmain';

}
