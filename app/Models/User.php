<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
    'samaccountname', 'username', 'firstname', 'middlename', 'lastname', 'phone', 'dob', 'gender_id',
    'password', 'email', 'confirm_password','employer_id', 'designation_id', 'department_id', 'section_id',
    'project_name', 'location_project', 'created_by','last_login',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'confirm_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'confirm_password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        $name = trim(($this->firstname ?? '') . ' ' . ($this->middlename ?? '') . ' ' . ($this->lastname ?? ''));
        return !empty($name) ? $name : ($this->username ?? 'Unknown User');
    }

    /**
     * Append custom attributes to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];
}
