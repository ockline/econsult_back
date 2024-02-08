<?php

namespace App\Models\Sysdef;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected  $table = 'packages';
    protected $guarded = [];
    public $timestamps = true;
}
