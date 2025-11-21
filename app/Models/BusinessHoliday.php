<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BusinessHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'end_date',
    ];

    protected $dates = [
        'date',
        'end_date',
    ];

    /**
     * Check if this holiday is a single date or date range
     */
    public function isDateRange()
    {
        return !is_null($this->end_date) && $this->end_date != $this->date;
    }

    /**
     * Get formatted date range string for display
     */
    public function getFormattedDateRange()
    {
        if ($this->isDateRange()) {
            return Carbon::parse($this->date)->format('M d, Y') . ' - ' . Carbon::parse($this->end_date)->format('M d, Y');
        }
        
        return Carbon::parse($this->date)->format('M d, Y');
    }
}
