@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Broadcast SMS</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Send SMS to multiple recipients at once</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('sms.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-2m0 0l9 9m-9-2v6a2 2 0 002 2h2a2 2 0 002 2v6a2 2 0 002 2z"></path>
                </svg>
                Send SMS
            </a>
            <a href="{{ route('sms.scheduled') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V7m0 0v7m0 0h6m0 0v7m0 0h6M6 7v12a2 2 0 002-2 2H4a2 2 0 00-2-2V7a2 2 0 002 2z"></path>
                </svg>
                Scheduled
            </a>
            <a href="{{ route('sms.templates') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0v6m0 0h6m-6 0v6m0 0h6m-6 0v6m0 0h6M6 6v12a2 2 0 002-2 2H4a2 2 0 00-2-2V6a2 2 0 002 2z"></path>
                </svg>
                Templates
            </a>
        </div>
    </div>

    <!-- Broadcast Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📢 Create Broadcast</h2>
                <form action="{{ route('sms.broadcast.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Campaign Name</label>
                        <input type="text" name="campaign_name" required
                               placeholder="Enter campaign name for tracking"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sender ID</label>
                        <select name="sender_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Default Sender</option>
                            <option value="TANZANIATIP">TANZANIATIP</option>
                            <option value="CHURCH">CHURCH</option>
                            <option value="NOTIFICATIONS">NOTIFICATIONS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="4" required
                                  placeholder="Enter your broadcast message here..."
                                  maxlength="1600"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('message') }}</textarea>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-sm text-gray-500"><span id="charCount">0</span> / 1600 characters</span>
                            <button type="button" onclick="useTemplate()" class="text-sm text-purple-600 hover:text-purple-800">Use Template</button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Schedule Time (Optional)</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                                <input type="date" name="schedule_date" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                                <input type="time" name="schedule_time" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reference (Optional)</label>
                        <input type="text" name="reference" placeholder="Internal reference or campaign ID"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Internal notes about this broadcast"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-2m0 0l9 9m-9-2v6a2 2 0 002 2h2a2 2 0 002 2v6a2 2 0 002 2z"></path>
                            </svg>
                            Send Broadcast
                        </button>
                        <button type="button" onclick="clearForm()" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recipients Selection -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">👥 Select Recipients</h3>
                <div class="space-y-4">
                    <!-- Recipient Groups -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Send to Groups</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="recipient_groups[]" value="all_parishioners" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">All Parishioners</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="recipient_groups[]" value="choir_members" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Choir Members</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="recipient_groups[]" value="bbict_students" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">BBICT Students</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="recipient_groups[]" value="leaders" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Church Leaders</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="recipient_groups[]" value="youth" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                <span class="ml-2 text-sm text-gray-700">Youth Members</span>
                            </label>
                        </div>
                    </div>

                    <!-- Custom Recipients -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Phone Numbers</label>
                        <textarea name="custom_recipients" rows="4" 
                                  placeholder="Enter phone numbers separated by commas&#10;Example: 255716123456, 255758483019, 255654321098"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Format: 255XXXXXXXXX, separated by commas</p>
                    </div>

                    <!-- Upload Recipients -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Recipients File</label>
                        <input type="file" name="recipients_file" accept=".csv,.txt"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Upload CSV or TXT file with phone numbers</p>
                    </div>
                </div>
            </div>

            <!-- Estimated Cost -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">💰 Estimated Cost</h3>
                <div class="space-y-3">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-blue-700">Estimated Recipients:</span>
                            <span class="text-2xl font-bold text-blue-900" id="estimatedRecipients">0</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-blue-700">Cost per SMS:</span>
                            <span class="text-lg font-bold text-blue-900">TZS 16</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-blue-200">
                            <span class="text-sm font-medium text-blue-700">Total Estimated Cost:</span>
                            <span class="text-2xl font-bold text-blue-900" id="estimatedCost">TZS 0</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            <strong>Note:</strong> Actual cost may vary based on message length and recipient count.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Broadcasts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">📢 Recent Broadcasts</h2>
            <a href="{{ route('sms.log') }}" class="text-sm text-purple-600 hover:text-purple-800">View All Messages →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipients</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentBroadcasts->count() > 0)
                        @foreach($recentBroadcasts as $broadcast)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $broadcast->campaign_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $broadcast->recipient_count ?? 'Multiple' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600" title="{{ $broadcast->message }}">
                                    {{ Str::limit($broadcast->message, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($broadcast->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($broadcast->status == 'sent') bg-blue-100 text-blue-800
                                    @elseif($broadcast->status == 'failed') bg-red-100 text-red-800
                                    @elseif($broadcast->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $broadcast->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $broadcast->sent_at ? $broadcast->sent_at->diffForHumans() : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">TZS {{ number_format($broadcast->cost ?? 0, 2, '.', ',') }}</div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M16 12h.01M5 19H3a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002 2V5a2 2 0 00-2-2H5a2 2 0 00-2-2V5a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-2">No recent broadcasts</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Character counter
const messageTextarea = document.querySelector('textarea[name="message"]');
const charCount = document.getElementById('charCount');
const estimatedRecipients = document.getElementById('estimatedRecipients');
const estimatedCost = document.getElementById('estimatedCost');

messageTextarea.addEventListener('input', function() {
    const length = this.value.length;
    charCount.textContent = length;
    
    // Change color based on limit
    if (length > 1600) {
        charCount.classList.add('text-red-600');
        charCount.classList.remove('text-gray-500');
    } else {
        charCount.classList.add('text-gray-500');
        charCount.classList.remove('text-red-600');
    }
    
    updateCostEstimate();
});

// Update cost estimate when recipients change
document.querySelectorAll('input[name="recipient_groups[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateCostEstimate);
});

document.querySelector('textarea[name="custom_recipients"]').addEventListener('input', updateCostEstimate);

function updateCostEstimate() {
    let recipientCount = 0;
    
    // Count selected groups (estimated)
    document.querySelectorAll('input[name="recipient_groups[]"]:checked').forEach(checkbox => {
        switch(checkbox.value) {
            case 'all_parishioners': recipientCount += 500; break;
            case 'choir_members': recipientCount += 50; break;
            case 'bbict_students': recipientCount += 100; break;
            case 'leaders': recipientCount += 20; break;
            case 'youth': recipientCount += 80; break;
        }
    });
    
    // Count custom recipients
    const customRecipients = document.querySelector('textarea[name="custom_recipients"]').value;
    if (customRecipients.trim()) {
        recipientCount += customRecipients.split(',').filter(num => num.trim()).length;
    }
    
    const costPerSMS = 16;
    const totalCost = recipientCount * costPerSMS;
    
    estimatedRecipients.textContent = recipientCount;
    estimatedCost.textContent = `TZS ${totalCost.toLocaleString()}`;
}

function selectTemplate(message) {
    messageTextarea.value = message;
    messageTextarea.dispatchEvent(new Event('input'));
}

function useTemplate() {
    // Open template selection modal
    alert('Template selection feature coming soon!');
}

function clearForm() {
    document.querySelector('form').reset();
    charCount.textContent = '0';
    updateCostEstimate();
}

// Initialize cost estimate
updateCostEstimate();
</script>
@endsection
