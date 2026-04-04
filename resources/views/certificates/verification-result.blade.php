@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Certificate Verification Result</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Certificate authenticity confirmed</p>
        </div>
        <a href="{{ route('public.verify.form') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            ← Verify Another
        </a>
    </div>

    <!-- Certificate Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Certificate Verified</h2>
                    <p class="text-green-100">This certificate is authentic and valid</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Certificate Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Certificate Information</h3>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Certificate Number:</span>
                        <span class="text-sm text-gray-900 font-mono">{{ $certificate->certificate_number }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Type:</span>
                        <span class="text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $certificate->type === 'finalist' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($certificate->type) }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Recipient Name:</span>
                        <span class="text-sm text-gray-900">{{ $certificate->recipient_name }}</span>
                    </div>
                    
                    @if($certificate->group_name)
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Group Name:</span>
                        <span class="text-sm text-gray-900">{{ $certificate->group_name }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Issue Date:</span>
                        <span class="text-sm text-gray-900">{{ $certificate->issue_date->format('d F Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Template:</span>
                        <span class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $certificate->template_name)) }}</span>
                    </div>
                </div>

                <!-- Verification Details -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 pb-2 border-b border-gray-200">Verification Details</h3>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Verification Code:</span>
                        <span class="text-sm text-gray-900 font-mono">{{ $certificate->verification_code }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Verification Status:</span>
                        <span class="text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Verified
                            </span>
                        </span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Issued By:</span>
                        <span class="text-sm text-gray-900">{{ $certificate->issuedBy->name ?? 'System Administrator' }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Created Date:</span>
                        <span class="text-sm text-gray-900">{{ $certificate->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between py-2">
                        <span class="text-sm font-medium text-gray-600">Last Verified:</span>
                        <span class="text-sm text-gray-900">{{ now()->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            @if($certificate->description)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                <p class="text-gray-600">{{ $certificate->description }}</p>
            </div>
            @endif

            <!-- Security Features -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Security Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Unique Code</p>
                            <p class="text-xs text-gray-600">12-character verification</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Digital Record</p>
                            <p class="text-xs text-gray-600">Stored in secure database</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Timestamp</p>
                            <p class="text-xs text-gray-600">Creation & verification logs</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex flex-wrap gap-3">
                    <button onclick="printCertificate()" 
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Verification
                    </button>
                    
                    <button onclick="shareVerification()" 
                            class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                        </svg>
                        Share
                    </button>
                    
                    <button onclick="downloadPDF()" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Disclaimer -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-medium text-yellow-800">Important Notice</h4>
                <p class="text-sm text-yellow-700 mt-1">
                    This verification confirms the certificate exists in our database. For employment or educational purposes, 
                    please contact the issuing organization directly for additional verification if required.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function printCertificate() {
    window.print();
}

function shareVerification() {
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: 'Certificate Verification',
            text: 'View this verified certificate',
            url: url
        });
    } else {
        navigator.clipboard.writeText(url);
        alert('Verification link copied to clipboard!');
    }
}

function downloadPDF() {
    // This would generate and download a PDF of the verification
    alert('PDF download functionality would be implemented here');
}
</script>
@endsection
