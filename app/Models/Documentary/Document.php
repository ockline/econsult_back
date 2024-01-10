<?php

namespace App\Models\Documentary;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documentary\Traits\Attribute\DocumentAttribute;
use App\Models\Documentary\Traits\Relationship\DocumentRelationship;
/**
 * Class Country
 */
class Document extends Model {

    use DocumentAttribute, DocumentRelationship;


    public $timestamps = true;
    protected $fillable = [
	'name'
    ];
    protected $guarded = [];

}
