<?php

namespace App\Models\ContractManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected  $table = 'contracts';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
                'name', 'desciption','created_at','updated_at','deleted_at'
         ];
}
