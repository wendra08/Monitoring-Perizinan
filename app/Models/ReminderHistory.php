<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id',
        'reminder_type',
        'sent_to',
        'sent_by',
        'status',
        'error_message'
    ];

    // Relationship to Permit
    public function permit()
    {
        return $this->belongsTo(Permit::class);
    }

    // Get readable reminder type
    public function getReminderTypeLabel()
    {
        return match($this->reminder_type) {
            '6_months' => '6 Months Notice',
            '3_months' => '3 Months Notice',
            '1_month' => '1 Month Notice',
            'manual' => 'Manual Reminder',
            default => 'Unknown'
        };
    }
}
