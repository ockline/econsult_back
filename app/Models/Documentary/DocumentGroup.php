<?php

namespace App\Models\Documentary;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documentary\Traits\Attribute\DocumentGroupAttribute;
use App\Models\Documentary\Traits\Relationship\DocumentGroupRelationship;
/**
 * Class Country
 */
class DocumentGroup extends Model {

    use DocumentGroupAttribute, DocumentGroupRelationship;


    public $timestamps = true;
    protected $fillable = [
	'name'
    ];
    protected $guarded = [];

}
