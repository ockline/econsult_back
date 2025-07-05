<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    // Define the table associated with the Audit model
    protected $table = 'audits'; // Adjust if your table name is different

    // Specify which attributes are mass assignable
    protected $fillable = [
        'user_id',
        'event',
        'auditable_id',
        'auditable_type',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'user_type',
        'tags',
        'created_at',
        'updated_at',
        'deleted_at',
        'deleted_by',
    ];

    // Define the attribute types (for casting)
    protected $casts = [
        'old_values' => 'array',  // Cast JSON-like data to array
        'new_values' => 'array',  // Cast JSON-like data to array
        'created_at' => 'datetime', // Cast to datetime
        'updated_at' => 'datetime', // Cast to datetime
        'deleted_at' => 'datetime', // Cast to datetime
    ];

    // Optional: if you want to set the timestamps manually for deleted_at (soft deletes)
    public $timestamps = false;  // If you do not want auto-managed timestamps

    // If you're using soft deletes, you can enable the SoftDeletes trait:
    // use Illuminate\Database\Eloquent\SoftDeletes;
    // protected $dates = ['deleted_at'];
}
