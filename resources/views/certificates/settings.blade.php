@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Certificate Settings</h1>
            <p class="mt-2 text-gray-600">Configure certificate generation and management settings.</p>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('certificates.settings.update') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Auto Approval -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="auto_approval" class="text-sm font-medium text-gray-700">
                                        Auto Approval
                                    </label>
                                    <p class="text-sm text-gray-500">Automatically approve certificates without manual review</p>
                                </div>
                                <div class="ml-3">
                                    <input type="checkbox" id="auto_approval" name="auto_approval" 
                                           {{ $settings['auto_approval'] ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Send Email on Certificate Issued -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="send_email" class="text-sm font-medium text-gray-700">
                                        Send Email on Certificate Issued
                                    </label>
                                    <p class="text-sm text-gray-500">Automatically email PDF to member when certificate is approved</p>
                                </div>
                                <div class="ml-3">
                                    <input type="checkbox" id="send_email" name="send_email" 
                                           {{ $settings['send_email'] ?? false ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Send SMS Alert -->
                        <div class="col-span-2">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="send_sms" class="text-sm font-medium text-gray-700">
                                        Send SMS Alert
                                    </label>
                                    <p class="text-sm text-gray-500">Send SMS notification (cost consideration)</p>
                                </div>
                                <div class="ml-3">
                                    <input type="checkbox" id="send_sms" name="send_sms" 
                                           {{ $settings['send_sms'] ?? false ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Default Finalist Template -->
                        <div>
                            <label for="default_finalist_template" class="block text-sm font-medium text-gray-700">
                                Default Finalist Template
                            </label>
                            <select id="default_finalist_template" name="default_finalist_template" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="standard_finalist" {{ $settings['default_finalist_template'] === 'standard_finalist' ? 'selected' : '' }}>
                                    Standard Finalist
                                </option>
                                <option value="modern_finalist" {{ $settings['default_finalist_template'] === 'modern_finalist' ? 'selected' : '' }}>
                                    Modern Finalist
                                </option>
                                <option value="traditional_finalist" {{ $settings['default_finalist_template'] === 'traditional_finalist' ? 'selected' : '' }}>
                                    Traditional Finalist
                                </option>
                                <option value="achievement_finalist" {{ $settings['default_finalist_template'] === 'achievement_finalist' ? 'selected' : '' }}>
                                    Achievement Finalist
                                </option>
                            </select>
                        </div>

                        <!-- Default Group Template -->
                        <div>
                            <label for="default_group_template" class="block text-sm font-medium text-gray-700">
                                Default Group Template
                            </label>
                            <select id="default_group_template" name="default_group_template" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="standard_group" {{ $settings['default_group_template'] === 'standard_group' ? 'selected' : '' }}>
                                    Standard Group
                                </option>
                                <option value="modern_group" {{ $settings['default_group_template'] === 'modern_group' ? 'selected' : '' }}>
                                    Modern Group
                                </option>
                                <option value="traditional_group" {{ $settings['default_group_template'] === 'traditional_group' ? 'selected' : '' }}>
                                    Traditional Group
                                </option>
                                <option value="achievement_group" {{ $settings['default_group_template'] === 'achievement_group' ? 'selected' : '' }}>
                                    Achievement Group
                                </option>
                            </select>
                        </div>

                        <!-- Default Leadership Template -->
                        <div>
                            <label for="default_leadership_template" class="block text-sm font-medium text-gray-700">
                                Default Leadership Template
                            </label>
                            <select id="default_leadership_template" name="default_leadership_template" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="leadership_gold" {{ ($settings['default_leadership_template'] ?? 'leadership_gold') === 'leadership_gold' ? 'selected' : '' }}>
                                    Leadership Gold
                                </option>
                                <option value="leadership_silver" {{ ($settings['default_leadership_template'] ?? 'leadership_gold') === 'leadership_silver' ? 'selected' : '' }}>
                                    Leadership Silver
                                </option>
                                <option value="leadership_bronze" {{ ($settings['default_leadership_template'] ?? 'leadership_gold') === 'leadership_bronze' ? 'selected' : '' }}>
                                    Leadership Bronze
                                </option>
                            </select>
                        </div>

                        <!-- Default Event Template -->
                        <div>
                            <label for="default_event_template" class="block text-sm font-medium text-gray-700">
                                Default Event Template
                            </label>
                            <select id="default_event_template" name="default_event_template" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="event_simple" {{ ($settings['default_event_template'] ?? 'event_simple') === 'event_simple' ? 'selected' : '' }}>
                                    Event Simple
                                </option>
                                <option value="event_formal" {{ ($settings['default_event_template'] ?? 'event_simple') === 'event_formal' ? 'selected' : '' }}>
                                    Event Formal
                                </option>
                                <option value="event_casual" {{ ($settings['default_event_template'] ?? 'event_simple') === 'event_casual' ? 'selected' : '' }}>
                                    Event Casual
                                </option>
                            </select>
                        </div>

                        <!-- Certificate Number Prefix -->
                        <div>
                            <label for="certificate_prefix" class="block text-sm font-medium text-gray-700">
                                Certificate Number Prefix
                            </label>
                            <input type="text" id="certificate_prefix" name="certificate_prefix" 
                                   value="{{ $settings['certificate_prefix'] ?? 'MOCU-STJ-' }}"
                                   placeholder="e.g., MOCU-STJ-2026-"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Custom prefix for unique certificate IDs</p>
                        </div>

                        <!-- Certificate Expiry Days -->
                        <div>
                            <label for="expiry_days" class="block text-sm font-medium text-gray-700">
                                Certificate Expiry Days
                            </label>
                            <input type="number" id="expiry_days" name="expiry_days" 
                                   value="{{ $settings['expiry_days'] }}" min="0" max="3650"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-sm text-gray-500">Number of days before certificates expire (0 = no expiry)</p>
                        </div>

                        <!-- QR Code Settings -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">QR Code Settings</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- QR Code Size -->
                                <div>
                                    <label for="qr_code_size" class="block text-sm font-medium text-gray-700">
                                        QR Code Size (pixels)
                                    </label>
                                    <select id="qr_code_size" name="qr_code_size" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="100" {{ ($settings['qr_code_size'] ?? 150) == 100 ? 'selected' : '' }}>100px</option>
                                        <option value="150" {{ ($settings['qr_code_size'] ?? 150) == 150 ? 'selected' : '' }}>150px</option>
                                        <option value="200" {{ ($settings['qr_code_size'] ?? 150) == 200 ? 'selected' : '' }}>200px</option>
                                        <option value="250" {{ ($settings['qr_code_size'] ?? 150) == 250 ? 'selected' : '' }}>250px</option>
                                        <option value="300" {{ ($settings['qr_code_size'] ?? 150) == 300 ? 'selected' : '' }}>300px</option>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">QR code dimensions (50-300 pixels)</p>
                                </div>

                                <!-- QR Code Position -->
                                <div>
                                    <label for="qr_code_position" class="block text-sm font-medium text-gray-700">
                                        QR Code Position
                                    </label>
                                    <select id="qr_code_position" name="qr_code_position" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="bottom-right" {{ ($settings['qr_code_position'] ?? 'bottom-right') === 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                                        <option value="bottom-left" {{ ($settings['qr_code_position'] ?? 'bottom-right') === 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                                        <option value="top-right" {{ ($settings['qr_code_position'] ?? 'bottom-right') === 'top-right' ? 'selected' : '' }}>Top Right</option>
                                        <option value="top-left" {{ ($settings['qr_code_position'] ?? 'bottom-right') === 'top-left' ? 'selected' : '' }}>Top Left</option>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Where to place QR code on certificate</p>
                                </div>
                            </div>
                        </div>

                        <!-- Approval Workflow Settings -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Approval Workflow</h3>
                            
                            <div class="space-y-4">
                                <!-- Require Approval For -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Require Approval For:</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="require_approval_finalist" value="finalist" 
                                                   {{ ($settings['require_approval_finalist'] ?? true) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="require_approval_finalist" class="ml-2 text-sm text-gray-700">Finalist Certificates</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="require_approval_group" value="group" 
                                                   {{ ($settings['require_approval_group'] ?? false) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="require_approval_group" class="ml-2 text-sm text-gray-700">Group Certificates</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="require_approval_leadership" value="leadership" 
                                                   {{ ($settings['require_approval_leadership'] ?? true) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="require_approval_leadership" class="ml-2 text-sm text-gray-700">Leadership Certificates</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="require_approval_event" value="event" 
                                                   {{ ($settings['require_approval_event'] ?? false) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <label for="require_approval_event" class="ml-2 text-sm text-gray-700">Event Certificates</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Signature Image Upload -->
                        <div class="col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Chaplain Signature</h3>
                            
                            @if($settings['signature_image'])
                                <div class="mb-3">
                                    <img src="{{ asset($settings['signature_image']) }}" 
                                         alt="Chaplain Signature" 
                                         class="h-20 border border-gray-300 rounded">
                                </div>
                            @endif
                            
                            <div>
                                <label for="signature_image" class="block text-sm font-medium text-gray-700">
                                    Upload New Signature
                                </label>
                                <input type="file" id="signature_image" name="signature_image" 
                                       accept="image/*"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <p class="mt-1 text-sm text-gray-500">Upload Chaplain's signature for certificates (PNG/JPG, max 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('certificates.log') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
