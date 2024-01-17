<?php

namespace App\Models\Employer;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{


    // use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'employers';
    protected $guarded = [];
    public $timestamps = true;

//    protected $fillable = [
//     'name', 'email', 'firstname', 'middlename', 'lastname', 'phone', 'dob', 'gender_id',
//     'password', 'email', 'confirm_password', 'designation_id', 'department_id', 'section_id',
//     'project_name', 'location_project',
// ];


}
