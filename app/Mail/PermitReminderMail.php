<?php

namespace App\Mail;

use App\Models\Permit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PermitReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permit;
    public $reminderType;

    public function __construct(Permit $permit, $reminderType)
    {
        $this->permit = $permit;
        $this->reminderType = $reminderType;
    }

    public function envelope(): Envelope
    {
        $subject = 'Permit Expiry Reminder: ' . $this->permit->permit_name;

        if ($this->reminderType === '6_months') {
            $subject .= ' (6 Months Notice)';
        } elseif ($this->reminderType === '3_months') {
            $subject .= ' (3 Months Notice)';
        } elseif ($this->reminderType === '1_month') {
            $subject .= ' (1 Month Notice - URGENT)';
        }

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.permit-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
