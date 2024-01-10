<?php

namespace App\Models\Location\Traits\Relationship;

trait CountryRelationship {

    /**
     * @return mixed
     */
//Relation to the regions
    public function regions(){
        return $this->hasMany(\App\Models\Location\Region::class, 'country_id', 'id');
    }


}
