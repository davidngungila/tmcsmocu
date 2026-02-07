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
                $this->smsUrl = SystemSetting::getValue('sms_url') ?: env('SMS_URL', 'https://messaging-service.co.tz/link/sms/v1/text/single');
            }
        } catch (\Exception $e) {
            // Table might not exist yet, use fallback
            Log::warning('NotificationProvider table not available, using SystemSetting fallback: ' . $e->getMessage());
            $this->smsUsername = SystemSetting::getValue('sms_username') ?: env('SMS_USERNAME', 'emcatechn');
            $this->smsPassword = SystemSetting::getValue('sms_password') ?: env('SMS_PASSWORD', 'Emca@#12');
            $this->smsFrom = SystemSetting::getValue('sms_from') ?: env('SMS_FROM', 'OfisiLink');
            $this->smsUrl = SystemSetting::getValue('sms_url') ?: env('SMS_URL', 'https://messaging-service.co.tz/link/sms/v1/text/single');
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
                $smsFrom = $provider->sms_from;
                $smsUrl = $provider->sms_url;
            } else {
                $smsUsername = $this->smsUsername;
                $smsPassword = $this->smsPassword;
                $smsFrom = $this->smsFrom;
                $smsUrl = $this->smsUrl;
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

            // Check if URL contains '/api/sms/v1' - use POST with JSON
            $usePostMethod = strpos($smsUrl, '/api/sms/v1') !== false || strpos($smsUrl, '/api/') !== false;
            
            $curl = curl_init();
            
            if ($usePostMethod) {
                // Use POST method with JSON body and Basic Auth
                $auth = base64_encode($smsUsername . ':' . $smsPassword);
                
                $body = json_encode([
                    'from' => $smsFrom,
                    'to' => $phoneNumber,
                    'text' => $message,
                    'reference' => 'mis_' . time()
                ]);
                
                Log::debug('SMS API Request (POST)', [
                    'url' => $smsUrl,
                    'method' => 'POST',
                    'from' => $smsFrom,
                    'to' => $phoneNumber,
                    'provider' => $provider ? $provider->name : 'default'
                ]);
                
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $smsUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Basic ' . $auth,
                        'Content-Type: application/json',
                        'Accept: application/json'
                    ],
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_USERAGENT => 'MIS-SMS-Client/1.0'
                ));
            } else {
                // Use GET method with URL parameters (legacy support)
                $text = urlencode($message);
                $password = urlencode($smsPassword);
                
                $url = $smsUrl . 
                       '?username=' . urlencode($smsUsername) . 
                       '&password=' . $password . 
                       '&from=' . urlencode($smsFrom) . 
                       '&to=' . $phoneNumber . 
                       '&text=' . $text;
                
                Log::debug('SMS API Request (GET)', [
                    'url' => $url,
                    'method' => 'GET',
                    'from' => $smsFrom,
                    'to' => $phoneNumber,
                    'provider' => $provider ? $provider->name : 'default'
                ]);

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_USERAGENT => 'MIS-SMS-Client/1.0'
                ));
            }

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
                
                // Check if SMS was sent successfully based on response
                if ($httpCode == 200) {
                    // Check response content for success indicators
                    $responseLower = strtolower($response ?? '');
                    $responseData = json_decode($response, true);
                    
                    if (strpos($responseLower, 'success') !== false || 
                        strpos($responseLower, '200') !== false ||
                        strpos($responseLower, 'accepted') !== false ||
                        strpos($responseLower, 'sent') !== false ||
                        ($responseData !== null && isset($responseData['success']) && $responseData['success']) ||
                        ($responseData !== null && !isset($responseData['error']))) {
                        
                        Log::info('SMS sent successfully', [
                            'phone' => $phoneNumber,
                            'response' => $response,
                            'provider' => $provider ? $provider->name : 'default'
                        ]);
                        
                        return true;
                    } else {
                        $errorMsg = 'SMS API returned 200 but response indicates failure';
                        if ($responseData && isset($responseData['error'])) {
                            $errorMsg .= ': ' . $responseData['error'];
                        } elseif ($responseData && isset($responseData['message'])) {
                            $errorMsg .= ': ' . $responseData['message'];
                        }
                        
                        Log::warning('SMS API returned 200 but content indicates failure', [
                            'phone' => $phoneNumber,
                            'response' => $response,
                            'provider' => $provider ? $provider->name : 'default'
                        ]);
                        throw new \Exception($errorMsg);
                    }
                } else {
                    $errorMsg = "SMS failed with HTTP code {$httpCode}";
                    if ($response) {
                        $errorMsg .= ': ' . substr($response, 0, 200);
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

