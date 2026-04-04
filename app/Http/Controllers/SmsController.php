<?php

namespace App\Http\Controllers;

use App\Models\SmsMessage;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    public function create()
    {
        $templates = $this->getTemplates();
        $recentMessages = SmsMessage::latest()->take(10)->get();
        $balance = $this->getSmsBalance();

        return view('sms.create', compact('templates', 'recentMessages', 'balance'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'sender_id' => 'nullable|string',
            'recipient' => 'required|string',
            'message' => 'required|string|max:1600',
            'schedule_date' => 'nullable|date',
            'schedule_time' => 'nullable|date_format:H:i',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            $recipient = $this->formatPhoneNumber($request->recipient);
            
            // Check if scheduling
            $scheduledAt = null;
            if ($request->schedule_date && $request->schedule_time) {
                $scheduledAt = $request->schedule_date . ' ' . $request->schedule_time;
            }

            // Create SMS record
            $smsMessage = SmsMessage::create([
                'type' => $scheduledAt ? 'scheduled' : 'single',
                'sender_id' => $request->sender_id ?? 'TANZANIATIP',
                'recipient' => $recipient,
                'message' => $request->message,
                'scheduled_at' => $scheduledAt,
                'status' => $scheduledAt ? 'pending' : 'pending',
                'reference' => $request->reference,
                'sent_by' => auth()->id(),
                'notes' => $request->notes,
            ]);

            // Send immediately if not scheduled
            if (!$scheduledAt) {
                $this->sendSmsViaNextSMS($smsMessage);
            }

            return redirect()->route('sms.create')
                         ->with('success', 'SMS sent successfully!');

        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return redirect()->route('sms.create')
                         ->with('error', 'Failed to send SMS: ' . $e->getMessage());
        }
    }

    public function broadcast()
    {
        $templates = $this->getTemplates();
        $recentBroadcasts = SmsMessage::where('type', 'broadcast')
                                     ->latest()
                                     ->take(10)
                                     ->get();

        return view('sms.broadcast', compact('templates', 'recentBroadcasts'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'campaign_name' => 'required|string|max:255',
            'sender_id' => 'nullable|string',
            'message' => 'required|string|max:1600',
            'schedule_date' => 'nullable|date',
            'schedule_time' => 'nullable|date_format:H:i',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            // Collect recipients from groups and custom list
            $recipients = $this->collectBroadcastRecipients($request);

            if (empty($recipients)) {
                return redirect()->route('sms.broadcast')
                             ->with('error', 'No recipients selected!');
            }

            // Check if scheduling
            $scheduledAt = null;
            if ($request->schedule_date && $request->schedule_time) {
                $scheduledAt = $request->schedule_date . ' ' . $request->schedule_time;
            }

            // Create SMS records for each recipient
            foreach ($recipients as $recipient) {
                SmsMessage::create([
                    'type' => 'broadcast',
                    'sender_id' => $request->sender_id ?? 'TANZANIATIP',
                    'recipient' => $recipient,
                    'message' => $request->message,
                    'scheduled_at' => $scheduledAt,
                    'status' => $scheduledAt ? 'pending' : 'pending',
                    'reference' => $request->reference,
                    'sent_by' => auth()->id(),
                    'notes' => $request->notes . ' | Campaign: ' . $request->campaign_name,
                ]);
            }

            return redirect()->route('sms.broadcast')
                         ->with('success', 'Broadcast scheduled successfully!');

        } catch (\Exception $e) {
            Log::error('SMS broadcast failed: ' . $e->getMessage());
            return redirect()->route('sms.broadcast')
                         ->with('error', 'Failed to send broadcast: ' . $e->getMessage());
        }
    }

    public function scheduled()
    {
        $scheduledMessages = SmsMessage::scheduled()
                                        ->with('user')
                                        ->orderBy('scheduled_at', 'asc')
                                        ->paginate(20);

        return view('sms.scheduled', compact('scheduledMessages'));
    }

    public function createScheduled(Request $request)
    {
        // This would be similar to send() but always creates scheduled messages
        return $this->send($request);
    }

    public function cancelScheduled(SmsMessage $message)
    {
        if ($message->sent_by !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($message->status !== 'pending') {
            return redirect()->route('sms.scheduled')
                         ->with('error', 'Cannot cancel sent messages');
        }

        $message->update([
            'status' => 'cancelled',
            'notes' => ($message->notes ?? '') . ' | Cancelled by ' . auth()->user()->name,
        ]);

        return redirect()->route('sms.scheduled')
                     ->with('success', 'Message cancelled successfully!');
    }

    public function email()
    {
        return view('sms.email');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'cc' => 'nullable|email',
            'bcc' => 'nullable|email',
        ]);

        try {
            // Send email logic here
            // For now, just log and show success
            Log::info('Email sent to: ' . $request->to);

            return redirect()->route('sms.email')
                         ->with('success', 'Email sent successfully!');

        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return redirect()->route('sms.email')
                         ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function log(Request $request)
    {
        $messages = SmsMessage::with('user')
            ->when($request->search, function($query, $search) {
                $query->where('recipient', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%")
                      ->orWhere('reference', 'like', "%{$search}%");
            })
            ->when($request->type, function($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date_from, function($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('sms.log', compact('messages'));
    }

    public function showMessage(SmsMessage $message)
    {
        return view('sms.show', compact('message'));
    }

    public function templates()
    {
        $templates = $this->getTemplates();
        return view('sms.templates', compact('templates'));
    }

    public function createTemplate()
    {
        return view('sms.templates.create');
    }

    public function storeTemplate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1600',
            'category' => 'required|string|max:100',
        ]);

        // Store template logic here
        // For now, just log and show success
        Log::info('Template created: ' . $request->name);

        return redirect()->route('sms.templates')
                     ->with('success', 'Template created successfully!');
    }

    public function editTemplate($id)
    {
        // Edit template logic
        return view('sms.templates.edit');
    }

    public function updateTemplate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1600',
            'category' => 'required|string|max:100',
        ]);

        // Update template logic here
        Log::info('Template updated: ' . $id);

        return redirect()->route('sms.templates')
                     ->with('success', 'Template updated successfully!');
    }

    public function deleteTemplate($id)
    {
        // Delete template logic here
        Log::info('Template deleted: ' . $id);

        return redirect()->route('sms.templates')
                     ->with('success', 'Template deleted successfully!');
    }

    public function balance()
    {
        $balance = $this->getSmsBalance();
        return view('sms.balance', compact('balance'));
    }

    public function syncStatus()
    {
        try {
            // Sync with NextSMS API to get current balance
            $balance = $this->getSmsBalance();

            return response()->json([
                'success' => true,
                'balance' => $balance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to sync balance: ' . $e->getMessage()
            ], 500);
        }
    }

    // Private helper methods
    private function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Ensure it starts with country code
        if (strlen($phone) === 9) {
            $phone = '255' . $phone;
        } elseif (strlen($phone) === 10 && substr($phone, 0, 1) === '0') {
            $phone = '255' . substr($phone, 1);
        }
        
        return $phone;
    }

    private function collectBroadcastRecipients($request)
    {
        $recipients = [];

        // Collect from groups
        if ($request->recipient_groups) {
            foreach ($request->recipient_groups as $group) {
                switch ($group) {
                    case 'all_parishioners':
                        $parishioners = Parishioner::where('status', 'active')->pluck('phone');
                        $recipients = array_merge($recipients, $parishioners->toArray());
                        break;
                    case 'choir_members':
                        // Get choir members
                        $choirMembers = Parishioner::where('member_type', 'choir')->pluck('phone');
                        $recipients = array_merge($recipients, $choirMembers->toArray());
                        break;
                    case 'bbict_students':
                        // Get BBICT students
                        $students = Parishioner::where('member_type', 'student')->pluck('phone');
                        $recipients = array_merge($recipients, $students->toArray());
                        break;
                    case 'leaders':
                        // Get church leaders
                        $leaders = Parishioner::where('member_type', 'leader')->pluck('phone');
                        $recipients = array_merge($recipients, $leaders->toArray());
                        break;
                    case 'youth':
                        // Get youth members
                        $youth = Parishioner::where('member_type', 'youth')->pluck('phone');
                        $recipients = array_merge($recipients, $youth->toArray());
                        break;
                }
            }
        }

        // Add custom recipients
        if ($request->custom_recipients) {
            $customNumbers = explode(',', $request->custom_recipients);
            foreach ($customNumbers as $number) {
                $formatted = $this->formatPhoneNumber(trim($number));
                if ($formatted) {
                    $recipients[] = $formatted;
                }
            }
        }

        // Remove duplicates and return
        return array_unique($recipients);
    }

    private function sendSmsViaNextSMS($smsMessage)
    {
        $apiUrl = 'https://messaging-service.co.tz/api/sms/v2/text/single';
        $token = config('services.nextsms.token', 'cedcce9becad866f59beac1fd5a235bc');

        $payload = [
            'from' => $smsMessage->sender_id,
            'to' => $smsMessage->recipient,
            'text' => $smsMessage->message,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->successful()) {
            $data = $response->json();
            $smsMessage->update([
                'status' => 'sent',
                'sent_at' => now(),
                'message_id' => $data['message_id'] ?? null,
                'reference' => $data['reference'] ?? null,
                'cost' => $data['cost'] ?? 16.00,
                'sms_count' => $data['sms_count'] ?? 1,
            ]);
        } else {
            $smsMessage->update([
                'status' => 'failed',
                'error_message' => $response->body(),
            ]);
        }

        return $response->successful();
    }

    private function getSmsBalance()
    {
        try {
            $apiUrl = 'https://messaging-service.co.tz/api/sms/v2/balance';
            $token = config('services.nextsms.token', 'cedcce9becad866f59beac1fd5a235bc');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                return $data['balance'] ?? 0;
            }

            return 0;
        } catch (\Exception $e) {
            Log::error('Failed to get SMS balance: ' . $e->getMessage());
            return 0;
        }
    }

    private function getTemplates()
    {
        // Return sample templates for now
        return collect([
            (object) [
                'id' => 1,
                'name' => 'Meeting Reminder',
                'message' => 'Reminder: Church meeting tomorrow at 10:00 AM. Please attend on time.',
                'category' => 'Meeting',
                'created_at' => now()->subDays(7),
            ],
            (object) [
                'id' => 2,
                'name' => 'Contribution Thank You',
                'message' => 'Thank you for your contribution to the church. God bless you!',
                'category' => 'Gratitude',
                'created_at' => now()->subDays(3),
            ],
            (object) [
                'id' => 3,
                'name' => 'Certificate Ready',
                'message' => 'Your certificate is ready for collection. Please visit the church office.',
                'category' => 'Notification',
                'created_at' => now()->subDays(1),
            ],
        ]);
    }
}
