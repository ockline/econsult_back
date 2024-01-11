<?php

namespace App\Models\Sysdef;

use App\Models\Location\Region;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{








    /**
     * RELATIONSHIP
     */

    public function region()
    {
        return $this->belongsTo(Region::class);
    }


}
