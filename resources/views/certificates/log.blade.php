@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Certificate Log</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">View and manage all generated certificates</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('certificates.templates') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Templates
            </a>
            <a href="{{ route('certificates.finalist.create') }}" 
               class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                + Generate Certificate
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Certificates</p>
                    <p class="text-xl font-bold text-gray-900">{{ $certificates->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Finalist Certificates</p>
                    <p class="text-xl font-bold text-gray-900">{{ $certificates->where('type', 'finalist')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Group Certificates</p>
                    <p class="text-xl font-bold text-gray-900">{{ $certificates->where('type', 'group')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-gray-200 p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Verified</p>
                    <p class="text-xl font-bold text-gray-900">{{ $certificates->where('is_verified', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       placeholder="Search by name or certificate number..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Types</option>
                    <option value="finalist">Finalist</option>
                    <option value="group">Group</option>
                </select>
            </div>
            
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">All Status</option>
                    <option value="verified">Verified</option>
                    <option value="unverified">Unverified</option>
                </select>
            </div>
            
            <div class="pt-6">
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Certificates Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Group</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verification Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($certificates as $certificate)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $certificate->certificate_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $certificate->type === 'finalist' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($certificate->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $certificate->recipient_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $certificate->group_name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $certificate->issue_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-600">{{ $certificate->verification_code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $certificate->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                  ($certificate->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($certificate->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <!-- Preview Button -->
                            <button onclick="previewCertificate({{ $certificate->id }})" 
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-full transition-colors"
                                    title="Preview Certificate">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </button>
                            
                            <!-- View Details Button -->
                            <a href="{{ route('certificates.show', $certificate) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors ml-1"
                               title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h1M5 12H4a1 1 0 00-1 1v4a1 1 0 001 1h1m1 4h1"></path>
                                </svg>
                            </a>
                            
                            <!-- Download Button -->
                            <a href="{{ route('certificates.download', $certificate) }}" 
                               class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-full transition-colors ml-1"
                               title="Download Certificate">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l6 6m-6 6H6"></path>
                                </svg>
                            </a>
                            
                            <!-- Revoke Button (only for approved certificates) -->
                            @if($certificate->status === 'approved')
                                <form method="POST" action="{{ route('certificates.revoke', $certificate) }}" 
                                      class="inline ml-1" 
                                      onsubmit="return confirm('Are you sure you want to revoke this certificate?')">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-full transition-colors"
                                            title="Revoke Certificate">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No certificates found. <a href="{{ route('certificates.finalist.create') }}" class="text-purple-600 hover:underline">Generate your first certificate</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($certificates->hasPages())
        <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="{{ $certificates->previousPageUrl() }}" 
                   class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="{{ $certificates->nextPageUrl() }}" 
                   class="ml-3 relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $certificates->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $certificates->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $certificates->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    {{ $certificates->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full z-50 hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Certificate Preview</h3>
                    <button onclick="closePreviewModal()" type="button" class="rounded-md p-2 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="previewContent" class="mt-4">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentPreviewUrl = '';
let previewInterval = null;

function previewCertificate(certificateId) {
    // Show loading state
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('previewContent');
    
    modal.classList.remove('hidden');
    content.innerHTML = '<div class="text-center py-8"><div class="inline-flex items-center"><svg class="animate-spin h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V8a2 2 0 00-2-2h4.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V8a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><span class="text-gray-600">Loading preview...</span></div></div>';
    
    // Clear any existing interval
    if (previewInterval) {
        clearInterval(previewInterval);
    }
    
    // Check if certificate PDF is ready
    previewInterval = setInterval(() => {
        fetch(`/certificates/${certificateId}/preview`)
            .then(response => response.json())
            .then(data => {
                if (data.pdf_url) {
                    content.innerHTML = `<iframe src="${data.pdf_url}" class="w-full h-96 border-0 rounded-lg"></iframe>`;
                    clearInterval(previewInterval);
                } else if (data.error) {
                    content.innerHTML = `<div class="text-red-600">Error: ${data.error}</div>`;
                    clearInterval(previewInterval);
                }
            })
            .catch(error => {
                content.innerHTML = `<div class="text-red-600">Error loading preview</div>`;
                clearInterval(previewInterval);
            });
    }, 1000);
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    modal.classList.add('hidden');
    
    // Clear interval
    if (previewInterval) {
        clearInterval(previewInterval);
    }
}

// Close modal when clicking outside
document.getElementById('previewModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closePreviewModal();
    }
});
</script>
@endsection
