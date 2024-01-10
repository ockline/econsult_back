<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location\Traits\Relationship\PostCodeRelationship;
use App\Models\Location\Traits\Attribute\PostCodeAttribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostCode
 */
class PostCode extends Model {

    use  PostCodeRelationship, PostCodeAttribute, SoftDeletes;


    public $timestamps = true;
    protected $guarded = [];


}
