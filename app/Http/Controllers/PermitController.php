<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Permit;
use App\Models\ReminderHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PermitReminderMail;
use Carbon\Carbon;

class PermitController extends Controller
{
     public function dashboard()
    {
        $totalPermits = Permit::count();
        $activePermits = Permit::where('status', 'active')->count();
        $expiredPermits = Permit::where('status', 'expired')->count();
        $renewedPermits = Permit::where('status', 'renewed')->count();

        // Permits expiring in different timeframes
        $expiringIn1Month = Permit::where('status', 'active')
            ->whereBetween('expiry_date', [now(), now()->addDays(30)])
            ->count();

        $expiringIn3Months = Permit::where('status', 'active')
            ->whereBetween('expiry_date', [now(), now()->addDays(90)])
            ->count();

        $expiringIn6Months = Permit::where('status', 'active')
            ->whereBetween('expiry_date', [now(), now()->addDays(180)])
            ->count();

        // Recent reminders sent
        $recentReminders = ReminderHistory::with('permit')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Upcoming expiring permits
        $upcomingExpiring = Permit::where('status', 'active')
            ->where('expiry_date', '>', now())
            ->orderBy('expiry_date', 'asc')
            ->limit(5)
            ->get();

        // Permits by status for chart
        $permitsByStatus = [
            'active' => $activePermits,
            'expired' => $expiredPermits,
            'renewed' => $renewedPermits
        ];

        return view('dashboard', compact(
            'totalPermits',
            'activePermits',
            'expiredPermits',
            'renewedPermits',
            'expiringIn1Month',
            'expiringIn3Months',
            'expiringIn6Months',
            'recentReminders',
            'upcomingExpiring',
            'permitsByStatus'
        ));
    }
    // Display all permits
    public function index(Request $request)
    {
        $query = Permit::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('permit_name', 'like', "%{$search}%")
                ->orWhere('permit_number', 'like', "%{$search}%")
                ->orWhere('boss_name', 'like', "%{$search}%")
                ->orWhere('boss_email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by expiry timeframe
        if ($request->filled('expiry')) {
            switch ($request->expiry) {
                case 'expired':
                    $query->where('expiry_date', '<', now());
                    break;
                case '30_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(30)]);
                    break;
                case '60_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(60)]);
                    break;
                case '90_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(90)]);
                    break;
                case '180_days':
                    $query->whereBetween('expiry_date', [now(), now()->addDays(180)]);
                    break;
            }
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'expiry_date');
        $sortOrder = $request->get('sort_order', 'asc');

        $query->orderBy($sortBy, $sortOrder);

        $permits = $query->get();

        return view('permits.index', compact('permits'));
    }

    // Show create form
    public function create()
    {
        return view('permits.create');
    }

    // Store new permit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'permit_name' => 'required|string|max:255',
            'permit_number' => 'nullable|string|unique:permits,permit_number',
            'division' => 'required|string|max:255',
            'division_email' => 'nullable|email',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'boss_name' => 'required|string|max:255',
            'boss_email' => 'required|email',
            'boss_email_2' => 'nullable|email',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // (10MB max)
            'reminder_categories' => 'required|array|min:1',
            'reminder_categories.*' => 'in:6_months,3_months,1_month'
        ]);

        // Handle file upload
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('permits', $fileName, 'public');

            $validated['document_path'] = $filePath;
            $validated['document_original_name'] = $file->getClientOriginalName();
        }

        Permit::create($validated);

        return redirect()->route('permits.index')->with('success', 'Permit created successfully!');
    }


    // Show edit form
    public function edit(Permit $permit)
    {
        return view('permits.edit', compact('permit'));
    }

    // Update permit
    public function update(Request $request, Permit $permit)
    {
        $validated = $request->validate([
            'permit_name' => 'required|string|max:255',
            'permit_number' => 'nullable|string|unique:permits,permit_number,' . $permit->id,
            'division' => 'required|string|max:255',
            'division_email' => 'nullable|email',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'boss_name' => 'required|string|max:255',
            'boss_email' => 'required|email',
            'boss_email_2' => 'nullable|email',
            'description' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Add this
            'status' => 'required|in:active,expired,renewed',
            'reminder_categories' => 'required|array|min:1',
            'reminder_categories.*' => 'in:6_months,3_months,1_month'
        ]);

        // Handle document removal
        if ($request->has('remove_document') && $permit->document_path) {
            Storage::disk('public')->delete($permit->document_path);
            $validated['document_path'] = null;
            $validated['document_original_name'] = null;
        }

        // Handle new file upload
        if ($request->hasFile('document')) {
            // Delete old file if exists
            if ($permit->document_path) {
                Storage::disk('public')->delete($permit->document_path);
            }

            $file = $request->file('document');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('permits', $fileName, 'public');

            $validated['document_path'] = $filePath;
            $validated['document_original_name'] = $file->getClientOriginalName();
        }

        $permit->update($validated);

        return redirect()->route('permits.index')->with('success', 'Permit updated successfully!');
    }

    // Delete permit
    public function destroy(Permit $permit)
    {
        // Delete document if exists
        if ($permit->document_path) {
            Storage::disk('public')->delete($permit->document_path);
        }

        $permit->delete();
        return redirect()->route('permits.index')->with('success', 'Permit deleted successfully!');
    }

    // Send manual reminder with selected type
   // Replace the sendReminder method
    public function sendReminder(Request $request, Permit $permit)
    {
        $validated = $request->validate([
            'reminder_type' => 'required|in:6_months,3_months,1_month,manual'
        ]);

        $reminderType = $validated['reminder_type'];
        $status = true;
        $errorMessage = null;
        // Build recipients list from permit email fields because getAllRecipients() does not return a value
        $recipients = array_filter(array_unique([
            $permit->boss_email,
            $permit->boss_email_2,
            $permit->division_email,
        ]));

        if (empty($recipients)) {
            return redirect()->route('permits.index')->with('error', 'No email recipients found for this permit!');
        }

        try {
            // Send to all recipients
            Mail::to($recipients)->send(new PermitReminderMail($permit, $reminderType));

            // Mark the reminder as sent if it's not a custom manual reminder
            if ($reminderType !== 'manual') {
                $permit->markReminderSent($reminderType);
            }

            $reminderLabel = [
                '6_months' => '6 Months',
                '3_months' => '3 Months',
                '1_month' => '1 Month',
                'manual' => 'Manual'
            ][$reminderType];

            $recipientList = implode(', ', $recipients);
            $successMessage = "{$reminderLabel} reminder email sent successfully to: {$recipientList}";
        } catch (\Exception $e) {
            $status = false;
            $errorMessage = $e->getMessage();
            $successMessage = null;
        }

        // Save to reminder history (save each recipient)
        foreach ($recipients as $recipient) {
            ReminderHistory::create([
                'permit_id' => $permit->id,
                'reminder_type' => $reminderType,
                'sent_to' => $recipient,
                'status' => $status,
                'error_message' => $errorMessage
            ]);
        }

        if ($status) {
            return redirect()->route('permits.index')->with('success', $successMessage);
        } else {
            return redirect()->route('permits.index')->with('error', 'Failed to send email: ' . $errorMessage);
        }
    }

    // Add new method to show history
    public function history(Permit $permit)
    {
        $histories = $permit->reminderHistories()->orderBy('created_at', 'desc')->get();
        return view('permits.history', compact('permit', 'histories'));
    }

    // Add new method to show all histories
    public function allHistory()
    {
        $histories = ReminderHistory::with('permit')->orderBy('created_at', 'desc')->paginate(20);
        return view('permits.all-history', compact('histories'));
    }

    // Add this method to delete a single reminder history record
    public function destroyHistory(ReminderHistory $history)
    {
        $history->delete();
        return redirect()->back()->with('success', 'Reminder history deleted successfully!');
    }

    // Add this method to delete all history for a specific permit
    public function destroyAllHistory(Permit $permit)
    {
        $permit->reminderHistories()->delete();
        return redirect()->route('permits.history', $permit)->with('success', 'All reminder history deleted successfully!');
    }

    // Add this method to the controller
    public function calendar()
    {
        $permits = Permit::all();
        // Prepare events for calendar
        $events = [];

        foreach ($permits as $permit) {
            $daysUntilExpiry = $permit->daysUntilExpiry();

            // Determine color based on urgency
            if ($permit->isExpired()) {
                $color = '#ef4444'; // red
            } elseif ($daysUntilExpiry <= 30) {
                $color = '#ef4444'; // red
            } elseif ($daysUntilExpiry <= 90) {
                $color = '#f59e0b'; // yellow/orange
            } elseif ($daysUntilExpiry <= 180) {
                $color = '#3b82f6'; // blue
            } else {
                $color = '#10b981'; // green
            }

            $events[] = [
                'id' => $permit->id,
                'title' => $permit->permit_name,
                'start' => Carbon::parse($permit->expiry_date)->format('Y-m-d'),
                'color' => $color,
                'extendedProps' => [
                    'permit_number' => $permit->permit_number,
                    'boss_name' => $permit->boss_name,
                    'boss_email' => $permit->boss_email,
                    'issue_date' => Carbon::parse($permit->issue_date)->format('d M Y'),
                    'expiry_date' => Carbon::parse($permit->expiry_date)->format('d M Y'),
                    'days_until_expiry' => $daysUntilExpiry,
                    'status' => $permit->status
                ]
            ];
        }

        return view('permits.calendar', compact('events'));
    }

    // Bulk send reminders
    public function bulkReminder(Request $request)
    {
        $validated = $request->validate([
            'permit_ids' => 'required|json',
            'reminder_type' => 'required|in:6_months,3_months,1_month,manual'
        ]);

        $permitIds = json_decode($validated['permit_ids']);
        $reminderType = $validated['reminder_type'];

        $successCount = 0;
        $failCount = 0;

        foreach ($permitIds as $permitId) {
            $permit = Permit::find($permitId);

            if (!$permit) {
                $failCount++;
                continue;
            }

            $recipients = $permit->getAllRecipients();

            if (empty($recipients)) {
                $failCount++;
                continue;
            }

            try {
                Mail::to($recipients)->send(new PermitReminderMail($permit, $reminderType));

                // Mark reminder as sent if not manual
                if ($reminderType !== 'manual') {
                    $permit->markReminderSent($reminderType);
                }

                // Save to history for each recipient
                foreach ($recipients as $recipient) {
                    ReminderHistory::create([
                        'permit_id' => $permit->id,
                        'reminder_type' => $reminderType,
                        'sent_to' => $recipient,
                        'status' => true,
                        'error_message' => null
                    ]);
                }

                $successCount++;
            } catch (\Exception $e) {
                // Save failed attempt to history
                foreach ($recipients as $recipient) {
                    ReminderHistory::create([
                        'permit_id' => $permit->id,
                        'reminder_type' => $reminderType,
                        'sent_to' => $recipient,
                        'status' => false,
                        'error_message' => $e->getMessage()
                    ]);
                }

                $failCount++;
            }
        }

        $message = "Bulk reminder completed: {$successCount} permit(s) sent successfully";
        if ($failCount > 0) {
            $message .= ", {$failCount} failed";
        }

        return redirect()->route('permits.index')->with('success', $message);
    }

    // Bulk delete permits
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'permit_ids' => 'required|json'
        ]);

        $permitIds = json_decode($validated['permit_ids']);

        // Delete documents for all permits
        $permits = Permit::whereIn('id', $permitIds)->get();
        foreach ($permits as $permit) {
            if ($permit->document_path) {
                Storage::disk('public')->delete($permit->document_path);
            }
        }

        $count = Permit::whereIn('id', $permitIds)->delete();

        return redirect()->route('permits.index')->with('success', "{$count} permit(s) deleted successfully!");
}

}


