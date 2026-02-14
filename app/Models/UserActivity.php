<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $table = 'user_activities';

    protected $fillable = ['user_id', 'activity_date', 'start_time', 'end_time', 'title', 'description', 'rating', 'status'];

protected $casts = [
    'activity_date' => 'date',
    'confirmed_at' => 'datetime',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
