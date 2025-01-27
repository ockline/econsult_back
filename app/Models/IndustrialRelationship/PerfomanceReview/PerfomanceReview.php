<?php

namespace App\Models\IndustrialRelationship\PerfomanceReview;

use Illuminate\Database\Eloquent\Model;

class PerfomanceReview extends Model {


        protected $table = 'perfomance_reviews';

    public $timestamps = true;
    protected $fillable = [
	    'rate_creterial',
        'employee_id',
        'employer_id',
        'review_date',
        'employee_name',
        'review_description',
        'review_attachment',
        'status',
        'stage',
        'count'
    ];
    protected $guarded = [];

}
