<?php

namespace App\Models\Sysdef\Traits\Relationship;

use App\Models\Auth\User;
use App\Models\Operation\Compliance\Member\Employer;
use App\Models\Task\Checker;
use App\Models\Operation\Claim\Hsp\CaseManagement\CaseManagement;

trait CodeValueRelationship {

    /**
     * @return mixed
     */
    public function code()
    {
        return $this->belongsTo(\App\Models\Sysdef\Code::class);
    }

    /**
     * @return mixed
     */
    // public function employers()
    // {
    //     return $this->belongsToMany(Employer::class, 'employer_sectors', 'business_sector_cv_id', 'employer_id')->withTimestamps();
    // }

    // public function checkers()
    // {
    //     return $this->hasMany(Checker::class, "checker_category_cv_id");
    // }

    // public function not()
    // {
    //     return $this->hasMany(Checker::class, "checker_category_cv_id");
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, "allocation_user", "allocation_cv_id", "user_id")->withTimestamps();
    // }

    // public function cases()
    // {
    //     return $this->hasMany(CaseManagement::class, "ward_category");
    // }

}
