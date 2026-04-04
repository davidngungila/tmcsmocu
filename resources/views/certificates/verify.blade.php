@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Certificate Verification</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Public portal to verify certificate authenticity</p>
        </div>
        <a href="{{ url('/') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            ← Back to Home
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <!-- Verification Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Verify Certificate</h2>
            <p class="text-gray-600">Enter the verification code to authenticate the certificate</p>
        </div>

        <form action="{{ route('public.verify') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Verification Code Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Verification Code</label>
                <div class="relative">
                    <input type="text" 
                           name="verification_code" 
                           required 
                           maxlength="12"
                           placeholder="Enter 12-character verification code"
                           class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 uppercase text-center tracking-widest">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    The verification code is typically found at the bottom of the certificate
                </p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" 
                        class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition font-medium">
                    Verify Certificate
                </button>
            </div>
        </form>

        <!-- Help Section -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-medium text-gray-900 mb-3">Need Help?</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p>• The verification code is a 12-character alphanumeric code</p>
                <p>• You can find it printed at the bottom of your certificate</p>
                <p>• If you cannot find the code, contact the issuing organization</p>
                <p>• For technical issues, please contact support</p>
            </div>
        </div>
    </div>

    <!-- Recent Verifications (Optional) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl mx-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Verifications</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">Certificate #CERT-2026-0001</p>
                    <p class="text-sm text-gray-600">Verified 2 hours ago</p>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Verified</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-900">Certificate #CERT-2026-0002</p>
                    <p class="text-sm text-gray-600">Verified 5 hours ago</p>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Verified</span>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-format verification code to uppercase
document.addEventListener('DOMContentLoaded', function() {
    const verificationInput = document.querySelector('input[name="verification_code"]');
    if (verificationInput) {
        verificationInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endsection
