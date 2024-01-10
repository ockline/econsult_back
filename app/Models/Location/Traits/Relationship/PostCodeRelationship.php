<?php

namespace App\Models\Location\Traits\Relationship;

trait PostCodeRelationship {

    /**
     * @return mixed
     */
//Relation to the regions
    public function regions(){
        return $this->hasMany(\App\Models\Location\PostCode::class, 'district_id', 'id');
    }


}
