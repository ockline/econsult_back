<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Attribute\CountryAttribute;
use App\Models\Location\Traits\Relationship\CountryRelationship;
/**
 * Class Country
 */
class Country extends Model {

    use CountryAttribute, CountryRelationship;


    public $timestamps = true;
    protected $fillable = [
	'name'
    ];
    protected $guarded = [];

}
