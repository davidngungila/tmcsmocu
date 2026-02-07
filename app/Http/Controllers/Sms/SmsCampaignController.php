<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsCampaign;
use App\Models\SmsTemplate;
use App\Models\SmsBatch;
use App\Models\SmsRecipient;
use App\Models\Parishioner;
use App\Models\Community;
use App\Models\ApostolicGroup;
use App\Models\Event;
use App\Models\NotificationProvider;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsCampaignController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create()
    {
        $templates = SmsTemplate::where('is_active', true)->get();
        $providers = NotificationProvider::getActive('sms');
        return view('sms.create', compact('templates', 'providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:160',
            'language' => 'required|in:swahili,english',
            'target_criteria' => 'required|array',
            'provider_id' => 'nullable|exists:notification_providers,id',
        ]);

        // Calculate recipient count and get recipients
        $recipients = $this->getRecipients($validated['target_criteria']);
        $recipientCount = count($recipients);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'pending_approval';
        $validated['recipient_count'] = $recipientCount;
        $validated['target_criteria'] = json_encode($validated['target_criteria']);

        $campaign = SmsCampaign::create($validated);

        // Store recipients for later sending
        foreach ($recipients as $recipient) {
            SmsRecipient::create([
                'campaign_id' => $campaign->id,
                'parishioner_id' => $recipient['id'] ?? null,
                'phone_number' => $recipient['phone'],
                'status' => 'pending',
            ]);
        }

        return redirect()->route('sms.approval.index')
            ->with('success', 'SMS campaign created and submitted for approval.');
    }

    private function getRecipients($criteria)
    {
        $recipients = [];
        $phoneNumbers = [];

        if (in_array('all_parishioners', $criteria)) {
            $parishioners = Parishioner::where('is_active', true)
                ->whereNotNull('contact_number')
                ->get();
            
            foreach ($parishioners as $parishioner) {
                $phone = $this->formatPhone($parishioner->contact_number);
                if ($phone && !in_array($phone, $phoneNumbers)) {
                    $recipients[] = [
                        'id' => $parishioner->id,
                        'phone' => $phone,
                        'name' => $parishioner->first_name . ' ' . $parishioner->last_name
                    ];
                    $phoneNumbers[] = $phone;
                }
            }
        }
        
        if (in_array('wanafunzi', $criteria)) {
            $parishioners = Parishioner::where('type', 'wanafunzi')
                ->where('is_active', true)
                ->whereNotNull('contact_number')
                ->get();
            
            foreach ($parishioners as $parishioner) {
                $phone = $this->formatPhone($parishioner->contact_number);
                if ($phone && !in_array($phone, $phoneNumbers)) {
                    $recipients[] = [
                        'id' => $parishioner->id,
                        'phone' => $phone,
                        'name' => $parishioner->first_name . ' ' . $parishioner->last_name
                    ];
                    $phoneNumbers[] = $phone;
                }
            }
        }
        
        if (in_array('wafanyakazi', $criteria)) {
            $parishioners = Parishioner::where('type', 'wafanyakazi')
                ->where('is_active', true)
                ->whereNotNull('contact_number')
                ->get();
            
            foreach ($parishioners as $parishioner) {
                $phone = $this->formatPhone($parishioner->contact_number);
                if ($phone && !in_array($phone, $phoneNumbers)) {
                    $recipients[] = [
                        'id' => $parishioner->id,
                        'phone' => $phone,
                        'name' => $parishioner->first_name . ' ' . $parishioner->last_name
                    ];
                    $phoneNumbers[] = $phone;
                }
            }
        }
        
        if (in_array('leaders', $criteria)) {
            $leaders = \App\Models\Leader::where('is_active', true)
                ->with('parishioner')
                ->get();
            
            foreach ($leaders as $leader) {
                if ($leader->parishioner && $leader->parishioner->contact_number) {
                    $phone = $this->formatPhone($leader->parishioner->contact_number);
                    if ($phone && !in_array($phone, $phoneNumbers)) {
                        $recipients[] = [
                            'id' => $leader->parishioner->id,
                            'phone' => $phone,
                            'name' => $leader->parishioner->first_name . ' ' . $leader->parishioner->last_name
                        ];
                        $phoneNumbers[] = $phone;
                    }
                }
            }
        }

        return $recipients;
    }

    private function formatPhone($phone)
    {
        if (!$phone) return null;
        
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (!str_starts_with($phone, '255')) {
            $phone = '255' . ltrim($phone, '0');
        }
        
        if (preg_match('/^255[0-9]{9}$/', $phone)) {
            return $phone;
        }
        
        return null;
    }

    private function calculateRecipients($criteria)
    {
        return count($this->getRecipients($criteria));
    }
}
