<?php

namespace App\Models\Sysdef;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Attribute\CountryAttribute;
use App\Models\Location\Traits\Relationship\CountryRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 */
class Role extends Model {

    use SoftDeletes;

        protected $table = 'roles';
    public $timestamps = true;
    protected $fillable = [
	'name','alias','description', 'status'
    ];
    protected $guarded = [];

}
