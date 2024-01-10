<?php

namespace App\Models\Sysdef\Traits\Attribute;

use Carbon\Carbon;
/**
 * Class CodeAttribute
 */
trait CodeAttribute {





    /*
     * Formatting tables column
     */


    /*
     *
     *
     */
    public function getSystemDefinedAttribute()
    {
        if ($this->systemDefined()){
            return 'true';
        }else {
            return 'false';
        }
    }





//    Flags
    public function systemDefined() {
        return $this->is_system_defined == 1;
    }





}
