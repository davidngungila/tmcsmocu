@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">SMS Approval</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Review and approve SMS campaigns</p>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="flex space-x-2 sm:space-x-4 border-b border-gray-200">
        <button onclick="showTab('pending')" id="tab-pending" class="px-4 sm:px-6 py-2 sm:py-3 font-bold text-sm sm:text-base border-b-2 border-purple-600 text-purple-600">
            Pending ({{ $pending->count() }})
        </button>
        <button onclick="showTab('approved')" id="tab-approved" class="px-4 sm:px-6 py-2 sm:py-3 font-bold text-sm sm:text-base border-b-2 border-transparent text-gray-600 hover:text-gray-800">
            Approved ({{ $approved->count() }})
        </button>
        <button onclick="showTab('rejected')" id="tab-rejected" class="px-4 sm:px-6 py-2 sm:py-3 font-bold text-sm sm:text-base border-b-2 border-transparent text-gray-600 hover:text-gray-800">
            Rejected ({{ $rejected->count() }})
        </button>
    </div>
    
    <!-- Pending Tab -->
    <div id="content-pending" class="tab-content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto -mx-6 px-6">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Message</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Recipients</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Created By</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pending as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $campaign->title }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $campaign->message }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ number_format($campaign->recipient_count ?? 0) }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->creator->name ?? 'N/A' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <form action="{{ route('sms.approval.approve', $campaign->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                    </form>
                                    <button onclick="showRejectModal({{ $campaign->id }})" class="text-red-600 hover:text-red-900 font-medium">Reject</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                <p class="text-sm">No pending campaigns</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Approved Tab -->
    <div id="content-approved" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto -mx-6 px-6">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Approved By</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Approved At</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($approved as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $campaign->title }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->approver->name ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->approved_at ? $campaign->approved_at->format('M d, Y H:i') : 'N/A' }}</td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-500">
                                <p class="text-sm">No approved campaigns</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Rejected Tab -->
    <div id="content-rejected" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto -mx-6 px-6">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Rejected By</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Reason</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase">Rejected At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rejected as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm font-bold text-gray-900">{{ $campaign->title }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->approver->name ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->rejection_reason ?? 'N/A' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $campaign->approved_at ? $campaign->approved_at->format('M d, Y H:i') : 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-gray-500">
                                <p class="text-sm">No rejected campaigns</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Reject SMS Campaign</h3>
        <form id="reject-form" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Rejection Reason *</label>
                <textarea name="rejection_reason" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
            </div>
            <div class="flex items-center justify-end space-x-4">
                <button type="button" onclick="hideRejectModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-bold">
                    Reject
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showTab(tab) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
        document.querySelectorAll('[id^="tab-"]').forEach(btn => {
            btn.classList.remove('border-purple-600', 'text-purple-600');
            btn.classList.add('border-transparent', 'text-gray-600');
        });
        
        // Show selected tab
        document.getElementById('content-' + tab).classList.remove('hidden');
        const tabBtn = document.getElementById('tab-' + tab);
        tabBtn.classList.remove('border-transparent', 'text-gray-600');
        tabBtn.classList.add('border-purple-600', 'text-purple-600');
    }
    
    function showRejectModal(campaignId) {
        const form = document.getElementById('reject-form');
        form.action = '{{ url("sms/approval") }}/' + campaignId + '/reject';
        document.getElementById('reject-modal').classList.remove('hidden');
        document.getElementById('reject-modal').classList.add('flex');
    }
    
    function hideRejectModal() {
        document.getElementById('reject-modal').classList.add('hidden');
        document.getElementById('reject-modal').classList.remove('flex');
    }
</script>
@endsection

