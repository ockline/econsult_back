<?php

namespace App\Models\Bank;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    protected $guarded = [];
    public $timestamps = true;

    public function getNameFormattedAttribute()
    {
        // Format start date to "M d" (e.g., "Jul 1")
        $formattedStartDate = date('M d', strtotime($this->start_date));

        // Format end date to "M d" (e.g., "Sep 30")
        $formattedEndDate = date('M d', strtotime($this->end_date));

        // Combine the formatted start and end dates
        return "{$formattedStartDate} - {$formattedEndDate}";
    }
}
