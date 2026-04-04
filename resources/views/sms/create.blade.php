@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Send SMS</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Send individual SMS messages using NextSMS API</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('sms.broadcast') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M16 12h.01M5 19H3a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002 2V5a2 2 0 00-2-2H5a2 2 0 00-2-2V5a2 2 0 002 2z"></path>
                </svg>
                Broadcast
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
            <a href="{{ route('sms.balance') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 13h10l-8-8-8-8m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                </svg>
                Check Balance
            </a>
        </div>
    </div>

    <!-- SMS Send Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Send Single SMS -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📱 Send Single SMS</h2>
                <form action="{{ route('sms.send') }}" method="POST" class="space-y-4">
                    @csrf
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Phone Number</label>
                        <input type="tel" name="recipient" required
                               placeholder="255716123456"
                               pattern="[0-9]{10,13}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('recipient')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="4" required
                                  placeholder="Enter your message here..."
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
                        <textarea name="notes" rows="2" placeholder="Internal notes about this message"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-2m0 0l9 9m-9-2v6a2 2 0 002 2h2a2 2 0 002 2v6a2 2 0 002 2z"></path>
                            </svg>
                            Send SMS
                        </button>
                        <button type="button" onclick="clearForm()" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Templates -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📋 Quick Templates</h3>
                <div class="space-y-3">
                    @forelse ($templates->count() > 0)
                        @foreach($templates as $template)
                        <div class="p-3 border border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" onclick="selectTemplate('{{ $template->message }}')">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $template->name }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($template->message, 100) }}</p>
                                </div>
                                <span class="text-xs text-gray-400">{{ $template->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                            </svg>
                            <p class="mt-2">No templates available</p>
                            <p class="text-sm">Create message templates to quickly reuse common messages.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SMS Balance -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">💰 SMS Balance</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                        <div>
                            <p class="text-sm text-green-700">Current Balance</p>
                            <p class="text-2xl font-bold text-green-900">TZS {{ number_format($balance ?? 0, 2, '.', ',') }}</p>
                        </div>
                        <button onclick="checkBalance()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Refresh Balance
                        </button>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            <strong>Note:</strong> SMS charges apply based on NextSMS pricing.
                            <br>Standard SMS: TZS 16 per message
                            <br>Promotional SMS: TZS 20 per message
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">📤 Recent Messages</h2>
            <a href="{{ route('sms.log') }}" class="text-sm text-purple-600 hover:text-purple-800">View All Messages →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentMessages->count() > 0)
                        @foreach($recentMessages as $message)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $message->recipient }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600" title="{{ $message->message }}">
                                    {{ Str::limit($message->message, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($message->type == 'single') bg-blue-100 text-blue-800
                                    @elseif($message->type == 'broadcast') bg-purple-100 text-purple-800
                                    @elseif($message->type == 'scheduled') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $message->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($message->status == 'delivered') bg-green-100 text-green-800
                                    @elseif($message->status == 'sent') bg-blue-100 text-blue-800
                                    @elseif($message->status == 'failed') bg-red-100 text-red-800
                                    @elseif($message->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $message->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $message->sent_at ? $message->sent_at->diffForHumans() : '-' }}</div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                                    </svg>
                                    <p class="mt-2">No recent messages</p>
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
});

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
}

function checkBalance() {
    fetch('{{ route('sms.sync-status') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.balance) {
            document.querySelector('.text-green-900').textContent = `TZS ${data.balance}`;
        }
    })
    .catch(error => {
        console.error('Error checking balance:', error);
    });
}
    // Initialize count
    charCount.textContent = messageTextarea.value.length;
</script>
@endsection

