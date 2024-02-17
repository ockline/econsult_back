<?php

namespace App\Models\Hiring\Interview;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticalTestTranc extends Model
{
  use SoftDeletes;

    protected  $table = 'practical_test_tranc';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'practical_test_id','technical_interview_id', 'test_marks','practicl_test_remark','ranking_creterial_id','description'
    ];
}
