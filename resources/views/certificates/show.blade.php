@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                @if($certificate)
                    <!-- Certificate Found -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-3xl font-bold text-gray-900">Certificate Details</h1>
                            <div class="flex space-x-2">
                                @if($certificate->file_path)
                                    <a href="{{ asset($certificate->file_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l6 6m-6 6H6"></path>
                                        </svg>
                                        Download PDF
                                    </a>
                                @endif
                                
                                <a href="{{ route('certificates.download', $certificate) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-600 bg-white hover:bg-green-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 18 0m-6-2l-2-2m0 6a9 9 0 1118 0z"></path>
                                    </svg>
                                    Generate New PDF
                                </a>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Certificate Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Certificate Type</p>
                                    <p class="text-lg font-semibold">{{ ucfirst($certificate->type) }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Certificate Number</p>
                                    <p class="text-lg font-semibold font-mono">{{ $certificate->certificate_number }}</p>
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
                                    <p class="text-sm font-medium text-gray-700">Issue Date</p>
                                    <p class="text-lg font-semibold">{{ $certificate->issue_date->format('F j, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Template Used</p>
                                    <p class="text-lg font-semibold">{{ ucfirst(str_replace('_', ' ', $certificate->template_name)) }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Verification Code</p>
                                    <p class="text-lg font-semibold font-mono">{{ $certificate->verification_code }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Status</p>
                                    <p class="text-lg font-semibold">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $certificate->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $certificate->is_verified ? 'Verified' : 'Pending Verification' }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Issued By</p>
                                    <p class="text-lg font-semibold">{{ $certificate->issuedBy->name ?? 'System Administrator' }}</p>
                                </div>
                            </div>
                            
                            @if($certificate->description)
                            <div class="mt-6">
                                <p class="text-sm font-medium text-gray-700 mb-2">Description</p>
                                <p class="text-gray-600">{{ $certificate->description }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('certificates.log') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-600 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l-5 5m5 5H6"></path>
                                </svg>
                                Back to Certificate Log
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
                        
                        <div class="mt-6 text-center">
                            <a href="{{ route('certificates.log') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-600 bg-white hover:bg-blue-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l-5 5m5 5H6"></path>
                                </svg>
                                Back to Certificate Log
                            </a>
                        </div>
                    @endif
            </div>
        </div>
    </div>
</div>
@endsection
