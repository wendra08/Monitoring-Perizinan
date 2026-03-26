<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Permit extends Model
{
    use HasFactory;

    protected $fillable = [
   'permit_name',
    'permit_number',
    'division',
    'division_email',
    'issue_date',
    'expiry_date',
    'boss_name',
    'boss_email',
    'boss_email_2',
    'description',
    'document_path',
    'document_original_name',
    'status',
    'reminders_sent',
    'reminder_categories'
];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'reminders_sent' => 'array',
        'reminder_categories' => 'array' // Add this
    ];

    // Relationship to reminder histories
    public function reminderHistories()
    {
        return $this->hasMany(ReminderHistory::class);
    }

    // Check if permit is expired
    public function isExpired()
    {
        return $this->expiry_date < Carbon::today();
    }

    // Get days until expiry
    public function daysUntilExpiry()
    {
        return Carbon::today()->diffInDays($this->expiry_date, false);
    }

    // Check if reminder has been sent
    public function hasReminderBeenSent($type)
    {
        $reminders = $this->reminders_sent ?? [];
        return in_array($type, $reminders);
    }

    // Mark reminder as sent
    public function markReminderSent($type)
    {
        $reminders = $this->reminders_sent ?? [];
        if (!in_array($type, $reminders)) {
            $reminders[] = $type;
            $this->reminders_sent = $reminders;
            $this->save();
        }
    }

    // Check if permit has a specific reminder category
    public function hasReminderCategory($category)
    {
        $categories = $this->reminder_categories ?? [];
        return in_array($category, $categories);
    }

    // Get reminder categories as readable labels
    public function getReminderCategoriesLabels()
    {
        $categories = $this->reminder_categories ?? [];
        $labels = [];

        foreach ($categories as $category) {
            $labels[] = match($category) {
                '6_months' => '6 Months',
                '3_months' => '3 Months',
                '1_month' => '1 Month',
                default => $category
            };
        }

        return $labels;
    }
    public function getAllRecipients()
    {
        $recipients = [];

        if ($this->boss_email) {
            $recipients[] = $this->boss_email;
        }

        if ($this->boss_email_2) {
            $recipients[] = $this->boss_email_2;
        }

        if ($this->division_email) {
            $recipients[] = $this->division_email;
        }

        return array_unique($recipients); // Remove duplicates if any
    }
    public function getDocumentUrl()
    {
        if ($this->document_path) {
            return asset('storage/' . $this->document_path);
        }
        return null;
    }
    public function hasDocument()
    {
        return !empty($this->document_path) && \Storage::disk('public')->exists($this->document_path);
    }
}
