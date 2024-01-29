<?php

namespace App\Models\Employer;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employer extends Model
{

      use HasFactory, SoftDeletes;
    // use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'employers';
    protected $guarded = [];
    public $timestamps = true;

   protected $fillable = [
       'name','alia','email','reg_no','postal_address','contact_person','contact_person_phone','bank_id','bank_branch_id','account_no','account_name', 'tin','osha','wcf','nhif','nssf','phone','telephone','vrn','fax','region_id','district_id','location_type_id','ward_name','road','street','plot_number','block_number','cost_center','allowance_id','shift_id','working_days','working_hours','ward_id','created_by',
];


}
