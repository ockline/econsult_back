<?php

namespace App\Models\Sysdef;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

    protected  $table = 'shifts';
    protected $guarded = [];
    public $timestamps = true;
}
