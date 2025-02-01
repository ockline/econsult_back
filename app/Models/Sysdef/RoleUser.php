<?php

namespace App\Models\Sysdef;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Attribute\CountryAttribute;
use App\Models\Location\Traits\Relationship\CountryRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 */
class RoleUser extends Model {

    use SoftDeletes;

        protected $table = 'role_user';

    public $incrementing = true; // Ensures auto-increment is enabled
    protected $keyType = 'int';

    public $timestamps = true;
    protected $fillable = [
	'user_id',
'role_id',
'description',
'created_at',
'updated_at',
'deleted_at'
    ];
    protected $guarded = [];

}
