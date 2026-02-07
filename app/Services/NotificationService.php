<?php

namespace App\Services;

use App\Models\NotificationProvider;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    protected $smsUsername;
    protected $smsPassword;
    protected $smsFrom;
    protected $smsUrl;
    protected $smsProvider;
    protected $emailProvider;

    public function __construct()
    {
        try {
            // Get primary providers from database
            $this->smsProvider = NotificationProvider::getPrimary('sms');
            $this->emailProvider = NotificationProvider::getPrimary('email');
            
            // Fallback to SystemSetting if no provider found
            if ($this->smsProvider) {
                $this->smsUsername = $this->smsProvider->sms_username;
                $this->smsPassword = $this->smsProvider->sms_password;
                $this->smsFrom = $this->smsProvider->sms_from;
                $this->smsUrl = $this->smsProvider->sms_url;
            } else {
                // Fallback to SystemSetting, then env
                $this->smsUsername = SystemSetting::getValue('sms_username') ?: env('SMS_USERNAME', 'emcatechn');
                $this->smsPassword = SystemSetting::getValue('sms_password') ?: env('SMS_PASSWORD', 'Emca@#12');
                $this->smsFrom = SystemSetting::getValue('sms_from') ?: env('SMS_FROM', 'OfisiLink');
                // Hardcoded to Messaging Service API V2
                $this->smsUrl = SystemSetting::getValue('sms_url') ?: env('SMS_URL', 'https://messaging-service.co.tz/api/sms/v2/text/single');
            }
        } catch (\Exception $e) {
            // Table might not exist yet, use fallback
            Log::warning('NotificationProvider table not available, using SystemSetting fallback: ' . $e->getMessage());
            $this->smsUsername = SystemSetting::getValue('sms_username') ?: env('SMS_USERNAME', 'emcatechn');
            $this->smsPassword = SystemSetting::getValue('sms_password') ?: env('SMS_PASSWORD', 'Emca@#12');
            $this->smsFrom = SystemSetting::getValue('sms_from') ?: env('SMS_FROM', 'OfisiLink');
            // Hardcoded to Messaging Service API V2
            $this->smsUrl = SystemSetting::getValue('sms_url') ?: env('SMS_URL', 'https://messaging-service.co.tz/api/sms/v2/text/single');
        }
    }

    /**
     * Send SMS using GET method with URL parameters or POST with JSON
     */
    public function sendSMS(string $phoneNumber, string $message, ?NotificationProvider $provider = null)
    {
        try {
            // Use provided provider or fallback to default
            $provider = $provider ?? $this->smsProvider;
            
            if ($provider) {
                $smsUsername = $provider->sms_username;
                $smsPassword = $provider->sms_password;
                $smsToken = $provider->sms_token; // Bearer Token (preferred)
                $smsFrom = $provider->sms_from;
                // Hardcoded to Messaging Service API V2
                $smsUrl = $provider->sms_url ?: 'https://messaging-service.co.tz/api/sms/v2/text/single';
            } else {
                $smsUsername = $this->smsUsername;
                $smsPassword = $this->smsPassword;
                $smsToken = null;
                $smsFrom = $this->smsFrom;
                // Hardcoded to Messaging Service API V2
                $smsUrl = $this->smsUrl;
            }
            
            // Ensure URL is V2 API (hardcoded)
            if (strpos($smsUrl, '/api/sms/v2') === false) {
                $smsUrl = 'https://messaging-service.co.tz/api/sms/v2/text/single';
            }

            // Validate phone number format
            $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
            
            if (empty($phoneNumber) || !preg_match('/^255[0-9]{9}$/', $phoneNumber)) {
                // Try to fix format if not already in correct format
                if (!str_starts_with($phoneNumber, '255')) {
                    $phoneNumber = '255' . ltrim($phoneNumber, '0');
                }
                
                // Validate again after formatting
                if (!preg_match('/^255[0-9]{9}$/', $phoneNumber)) {
                    Log::error('SMS sending failed: Invalid phone number format', [
                        'phone' => $phoneNumber,
                        'expected_format' => '255XXXXXXXXX'
                    ]);
                    return false;
                }
            }

            // Debug log
            Log::info('Attempting to send SMS', [
                'phone' => $phoneNumber,
                'message' => substr($message, 0, 50) . (strlen($message) > 50 ? '...' : ''),
                'url' => $smsUrl,
                'from' => $smsFrom,
                'provider' => $provider ? $provider->name : 'default'
            ]);

            // Messaging Service API V2 - Always use POST with JSON
            $curl = curl_init();
            
            // Prepare request body for V2 API
            $body = json_encode([
                'from' => $smsFrom,
                'to' => $phoneNumber,
                'text' => $message,
                'reference' => 'tmcssmart_' . time() . '_' . uniqid()
            ]);
            
            // Determine authentication method (Bearer Token preferred, fallback to Basic Auth)
            $authHeader = '';
            if (!empty($smsToken)) {
                // Use Bearer Token authentication (recommended)
                $authHeader = 'Bearer ' . $smsToken;
            } elseif (!empty($smsUsername) && !empty($smsPassword)) {
                // Use Basic Authentication (username:password base64 encoded)
                $authHeader = 'Basic ' . base64_encode($smsUsername . ':' . $smsPassword);
            } else {
                throw new \Exception('SMS authentication credentials missing. Provide either Bearer Token or Username/Password.');
            }
            
            Log::debug('SMS API V2 Request', [
                'url' => $smsUrl,
                'method' => 'POST',
                'from' => $smsFrom,
                'to' => $phoneNumber,
                'auth_type' => !empty($smsToken) ? 'Bearer Token' : 'Basic Auth',
                'provider' => $provider ? $provider->name : 'default'
            ]);
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => $smsUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $authHeader,
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_USERAGENT => 'TmcsSmart-SMS-Client/2.0'
            ));

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);
            $curlErrno = curl_errno($curl);

            // Log detailed response
            Log::info('SMS Response', [
                'http_code' => $httpCode,
                'response' => $response,
                'provider' => $provider ? $provider->name : 'default'
            ]);

            if ($curlErrno) {
                $errorMsg = "cURL Error ({$curlErrno}): {$curlError}";
                Log::error('SMS cURL Error', [
                    'error_code' => $curlErrno,
                    'error_message' => $curlError,
                    'phone' => $phoneNumber,
                    'provider' => $provider ? $provider->name : 'default'
                ]);
                curl_close($curl);
                throw new \Exception($errorMsg);
            } else {
                curl_close($curl);
                
                // Check if SMS was sent successfully based on V2 API response
                if ($httpCode == 200) {
                    $responseData = json_decode($response, true);
                    
                    // V2 API success indicators
                    // Response may contain messageId or status indicating success
                    if ($responseData !== null) {
                        // Check for messageId (indicates message was accepted)
                        if (isset($responseData['messageId']) || 
                            (isset($responseData['status']) && 
                             (isset($responseData['status']['id']) && in_array($responseData['status']['id'], [51, 52, 88])))) {
                            
                            Log::info('SMS sent successfully (V2 API)', [
                                'phone' => $phoneNumber,
                                'messageId' => $responseData['messageId'] ?? null,
                                'status' => $responseData['status'] ?? null,
                                'provider' => $provider ? $provider->name : 'default'
                            ]);
                            
                            return true;
                        } elseif (isset($responseData['error']) || 
                                  (isset($responseData['status']) && 
                                   isset($responseData['status']['groupId']) && 
                                   $responseData['status']['groupId'] == 22)) {
                            // Failed status (groupId 22 = FAILED)
                            $errorMsg = 'SMS failed: ' . ($responseData['error'] ?? ($responseData['status']['name'] ?? 'Unknown error'));
                            Log::warning('SMS API V2 returned failure status', [
                                'phone' => $phoneNumber,
                                'response' => $response,
                                'provider' => $provider ? $provider->name : 'default'
                            ]);
                            throw new \Exception($errorMsg);
                        }
                    }
                    
                    // If we get here, assume success for 200 response
                    Log::info('SMS sent successfully (V2 API - 200 OK)', [
                        'phone' => $phoneNumber,
                        'response' => $response,
                        'provider' => $provider ? $provider->name : 'default'
                    ]);
                    
                    return true;
                } else {
                    $errorMsg = "SMS failed with HTTP code {$httpCode}";
                    if ($response) {
                        $responseData = json_decode($response, true);
                        if ($responseData && isset($responseData['error'])) {
                            $errorMsg .= ': ' . $responseData['error'];
                        } else {
                            $errorMsg .= ': ' . substr($response, 0, 200);
                        }
                    }
                    
                    Log::error('SMS failed with HTTP code', [
                        'http_code' => $httpCode,
                        'response' => $response,
                        'phone' => $phoneNumber,
                        'provider' => $provider ? $provider->name : 'default'
                    ]);
                    throw new \Exception($errorMsg);
                }
            }
        } catch (\Exception $e) {
            Log::error('SMS sending exception', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'phone' => $phoneNumber ?? 'unknown',
                'message_text' => $message ?? 'unknown',
                'provider' => $provider ? $provider->name : 'default'
            ]);
            return false;
        }
    }

    /**
     * Send bulk SMS to multiple recipients
     */
    public function sendBulkSMS(array $phoneNumbers, string $message, ?NotificationProvider $provider = null)
    {
        $results = [];
        $successCount = 0;
        $failureCount = 0;

        foreach ($phoneNumbers as $phoneNumber) {
            $result = $this->sendSMS($phoneNumber, $message, $provider);
            $results[$phoneNumber] = $result;
            
            if ($result) {
                $successCount++;
            } else {
                $failureCount++;
            }
            
            // Small delay to avoid rate limiting
            usleep(100000); // 0.1 second
        }

        return [
            'success' => $successCount,
            'failed' => $failureCount,
            'total' => count($phoneNumbers),
            'results' => $results
        ];
    }

    /**
     * Get all active SMS providers
     */
    public function getSmsProviders()
    {
        return NotificationProvider::getActive('sms');
    }
}

