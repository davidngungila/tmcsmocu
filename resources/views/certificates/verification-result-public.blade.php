@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                @if($certificate)
                    <!-- Certificate Found -->
                    <div class="text-center">
                        <div class="mb-6">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 18 0m-6-2l-2-2m0 6a9 9 0 1118 0z"></path>
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-green-600 mb-2">Certificate Verified</h1>
                            <p class="text-gray-600">This certificate is authentic and valid</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Certificate Details</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Certificate Type</p>
                                    <p class="text-lg font-semibold">{{ ucfirst($certificate->type) }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Recipient Name</p>
                                    <p class="text-lg font-semibold">{{ $certificate->recipient_name }}</p>
                                </div>
                                
                                @if($certificate->group_name)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Group Name</p>
                                    <p class="text-lg font-semibold">{{ $certificate->group_name }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Certificate Number</p>
                                    <p class="text-lg font-semibold font-mono">{{ $certificate->certificate_number }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Issue Date</p>
                                    <p class="text-lg font-semibold">{{ $certificate->issue_date->format('F j, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Verification Code</p>
                                    <p class="text-lg font-semibold font-mono">{{ $certificate->verification_code }}</p>
                                </div>
                            </div>
                            
                            @if($certificate->description)
                            <div class="mt-6">
                                <p class="text-sm font-medium text-gray-700">Description</p>
                                <p class="text-gray-600">{{ $certificate->description }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">Verification Information</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Status:</span>
                                    <span class="font-semibold text-green-600">✅ VALID</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Issued By:</span>
                                    <span class="font-semibold">{{ $certificate->issuedBy->name ?? 'System Administrator' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Verified On:</span>
                                    <span class="font-semibold">{{ now()->format('F j, Y, g:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ route('public.verify.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l-5 5m5 5H6"></path>
                                </svg>
                                Verify Another Certificate
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Certificate Not Found -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-red-600 mb-2">Certificate Not Found</h1>
                        <p class="text-gray-600 mb-6">The certificate you're looking for could not be found in our records.</p>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-red-900 mb-2">Possible Reasons</h3>
                            <ul class="list-disc list-inside space-y-2 text-gray-600">
                                <li>The certificate ID was entered incorrectly</li>
                                <li>The certificate has been revoked or expired</li>
                                <li>The certificate may not exist in our system</li>
                            </ul>
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="{{ route('public.verify.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l-5 5m5 5H6"></path>
                                </svg>
                                Try Again
                            </a>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
