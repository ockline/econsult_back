<?php

namespace App\Models\Location;

use App\Models\Location\Traits\Relationship\DistrictRelationship;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Attribute\CountryAttribute;
use App\Models\Location\Traits\Relationship\CountryRelationship;
/**
 * Class District
 */
class District extends Model {

use DistrictRelationship;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgmain';

    public $timestamps = true;
    protected $guarded = [];

}
