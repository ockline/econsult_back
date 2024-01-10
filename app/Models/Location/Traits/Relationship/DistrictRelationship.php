<?php

namespace App\Models\Location\Traits\Relationship;

trait DistrictRelationship {

    /**
     * @return mixed
     */
    public function region(){
        return $this->belongsTo(\App\Models\Location\Region::class);
    }

    

}
