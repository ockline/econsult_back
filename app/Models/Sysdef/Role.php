<?php

namespace App\Models\Sysdef;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Location\Traits\Attribute\CountryAttribute;
use App\Models\Location\Traits\Relationship\CountryRelationship;

/**
 * Class Country
 */
class Role extends Model {

    use SoftDeletes, Auditable;

     protected $table = 'roles';
    public $timestamps = true;
    protected $fillable = [
	'name','alias','description', 'status'
    ];
    protected $guarded = [];

}
