<?php

namespace App\Models\Sysdef;

use App\Models\Location\Region;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    /**
     * RELATIONSHIP
     */

    public function region()
    {
        return $this->hasMany(Region::class);
    }


}
