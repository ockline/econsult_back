<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Relationship\RegionRelationship;
use App\Models\Location\Traits\Attribute\RegionAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Region
 */
class Region extends Model {

    use  RegionRelationship, RegionAttribute, SoftDeletes;


    public $timestamps = true;
    protected $guarded = [];


}
