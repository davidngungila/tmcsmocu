<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\NotificationProvider;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationProviderController extends Controller
{
    public function index()
    {
        $providers = NotificationProvider::orderBy('type')->orderBy('is_primary', 'desc')->get();
        return view('settings.notification-providers.index', compact('providers'));
    }

    public function create()
    {
        return view('settings.notification-providers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sms_username' => 'nullable|string|max:255',
            'sms_password' => 'nullable|string|max:255',
            'sms_token' => 'nullable|string|max:255',
            'sms_from' => 'nullable|string|max:255',
            'sms_url' => 'nullable|url|max:500',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // If SMS URL is not provided, set default to V2 API
        if (empty($validated['sms_url']) && $validated['type'] === 'sms') {
            $validated['sms_url'] = 'https://messaging-service.co.tz/api/sms/v2/text/single';
        }
        
        // If SMS URL is not provided, set default to V2 API
        if (empty($validated['sms_url']) && $validated['type'] === 'sms') {
            $validated['sms_url'] = 'https://messaging-service.co.tz/api/sms/v2/text/single';
        }
        
        $provider = NotificationProvider::create($validated);

        // If set as primary, update others
        if ($validated['is_primary'] ?? false) {
            $provider->setAsPrimary();
        }

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider created successfully.');
    }

    public function edit($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        
        // Get provider usage statistics
        $usageStats = [];
        if ($provider->type === 'sms') {
            $usageStats = [
                'total_campaigns' => \App\Models\SmsCampaign::where('provider_id', $provider->id)->count(),
                'total_sent' => \App\Models\SmsRecipient::whereHas('campaign', function($q) use ($provider) {
                    $q->where('provider_id', $provider->id);
                })->where('status', 'sent')->count(),
                'total_failed' => \App\Models\SmsRecipient::whereHas('campaign', function($q) use ($provider) {
                    $q->where('provider_id', $provider->id);
                })->where('status', 'failed')->count(),
                'recent_campaigns' => \App\Models\SmsCampaign::where('provider_id', $provider->id)->latest()->limit(5)->get(),
            ];
        } else {
            // Email provider stats can be added here
            $usageStats = [
                'total_sent' => 0, // Can be tracked if email sending is logged
            ];
        }
        
        return view('settings.notification-providers.edit', compact('provider', 'usageStats'));
    }
    
    public function checkBalance($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        
        if ($provider->type !== 'sms') {
            return response()->json([
                'success' => false,
                'message' => 'Balance check is only available for SMS providers.'
            ], 400);
        }
        
        try {
            // Use Bearer Token or Basic Auth
            $authHeader = '';
            if (!empty($provider->sms_token)) {
                $authHeader = 'Bearer ' . $provider->sms_token;
            } elseif (!empty($provider->sms_username) && !empty($provider->sms_password)) {
                $authHeader = 'Basic ' . base64_encode($provider->sms_username . ':' . $provider->sms_password);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication credentials missing.'
                ], 400);
            }
            
            // Check balance using V2 API
            $balanceUrl = 'https://messaging-service.co.tz/api/v2/balance';
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $balanceUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $authHeader,
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_TIMEOUT => 30,
            ));
            
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);
            curl_close($curl);
            
            if ($httpCode == 200) {
                $balanceData = json_decode($response, true);
                return response()->json([
                    'success' => true,
                    'balance' => $balanceData
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to check balance: HTTP ' . $httpCode
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Balance check failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to check balance: ' . $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $provider = NotificationProvider::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'sms_username' => 'nullable|string|max:255',
            'sms_password' => 'nullable|string|max:255',
            'sms_token' => 'nullable|string|max:255',
            'sms_from' => 'nullable|string|max:255',
            'sms_url' => 'nullable|url|max:500',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Don't update password/token fields if they're empty (keep current)
        if (empty($validated['sms_password'])) {
            unset($validated['sms_password']);
        }
        if (empty($validated['sms_token'])) {
            unset($validated['sms_token']);
        }
        if (empty($validated['mail_password'])) {
            unset($validated['mail_password']);
        }
        
        // If SMS URL is not provided, set default to V2 API
        if (empty($validated['sms_url']) && $validated['type'] === 'sms') {
            $validated['sms_url'] = 'https://messaging-service.co.tz/api/sms/v2/text/single';
        }

        $provider->update($validated);

        // If set as primary, update others
        if ($validated['is_primary'] ?? false) {
            $provider->setAsPrimary();
        }

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider updated successfully.');
    }
    
    public function testEmail(Request $request, $id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $testEmail = $request->validate(['test_email' => 'required|email'])['test_email'];
        
        try {
            // Temporarily update mail config
            config([
                'mail.mailers.smtp.host' => $provider->mail_host,
                'mail.mailers.smtp.port' => $provider->mail_port,
                'mail.mailers.smtp.username' => $provider->mail_username,
                'mail.mailers.smtp.password' => $provider->mail_password,
                'mail.mailers.smtp.encryption' => $provider->mail_encryption,
                'mail.from.address' => $provider->mail_from_address,
                'mail.from.name' => $provider->mail_from_name,
            ]);
            
            Mail::raw('This is a test email from TmcsSmart notification system. Your email provider configuration is working correctly!', function ($message) use ($testEmail, $provider) {
                $message->to($testEmail)
                        ->subject('Test Email - TmcsSmart');
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $testEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Email test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 400);
        }
    }
    
    public function testSms(Request $request, $id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $testPhone = $request->validate(['test_phone' => 'required|string'])['test_phone'];
        
        try {
            $notificationService = new NotificationService();
            $testMessage = 'Test SMS from TmcsSmart. Your SMS provider configuration is working correctly!';
            
            $result = $notificationService->sendSMS($testPhone, $testMessage, $provider);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test SMS sent successfully to ' . $testPhone
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test SMS. Please check your configuration.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('SMS test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test SMS: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $provider->delete();

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Notification provider deleted successfully.');
    }

    public function setPrimary($id)
    {
        $provider = NotificationProvider::findOrFail($id);
        $provider->setAsPrimary();

        return redirect()->route('settings.notification-providers.index')
            ->with('success', 'Provider set as primary successfully.');
    }
}

