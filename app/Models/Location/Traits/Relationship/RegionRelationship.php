<?php

namespace App\Models\Location\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Location\District;
// use App\Models\Operation\Employer;
use App\Models\Sysdef\OfficeZone;

trait RegionRelationship {

    // public function employers()
    // {
    //     return $this->hasMany(Employer::class);
    // }

    //Relation to the country
    public function country(){
        return $this->belongsTo(\App\Models\Location\Country::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    //Relation to the office zone
    public function officeZone(){
        return $this->belongsTo(OfficeZone::class);
    }


}
