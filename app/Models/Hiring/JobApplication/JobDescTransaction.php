<?php

namespace App\Models\Hiring\JobApplication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobDescTransaction extends Model
{
    use SoftDeletes;

    protected  $table = 'job_desc_transactions';
    protected $guarded = [];
    public $timestamps = true;

    protected $fillable = [
        'name', 'job_title_id', 'employer_id', 'description', 'status', 'job_vacancy_id',
    ];
}
