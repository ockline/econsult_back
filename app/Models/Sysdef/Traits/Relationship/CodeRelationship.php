<?php

namespace App\Models\Sysdef\Traits\Relationship;

trait CodeRelationship {


//Relation to the Code Values
    public function codeValues(){
        return $this->hasMany(\App\Models\Sysdef\CodeValue::class);
    }


}
