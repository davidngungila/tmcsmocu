@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create SMS Campaign</h1>
        <p class="text-gray-600 mt-1">Create and send bulk SMS to parishioners</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('sms.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-base font-bold text-gray-700 mb-2">Campaign Title *</label>
                    <input type="text" id="title" name="title" required value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="language" class="block text-base font-bold text-gray-700 mb-2">Language *</label>
                    <select id="language" name="language" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="swahili" {{ old('language') === 'swahili' ? 'selected' : '' }}>Swahili</option>
                        <option value="english" {{ old('language') === 'english' ? 'selected' : '' }}>English</option>
                    </select>
                    @error('language')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="provider_id" class="block text-base font-bold text-gray-700 mb-2">SMS Provider</label>
                <select id="provider_id" name="provider_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    <option value="">Use Default Provider</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->name }} {{ $provider->is_primary ? '(Primary)' : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Leave empty to use the primary provider</p>
            </div>
            
            <div>
                <label for="message" class="block text-base font-bold text-gray-700 mb-2">Message *</label>
                <textarea id="message" name="message" rows="4" required maxlength="160" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('message') }}</textarea>
                <div class="mt-1 flex items-center justify-between">
                    <p class="text-sm text-gray-500">Maximum 160 characters</p>
                    <p class="text-sm text-gray-500"><span id="char-count">0</span>/160</p>
                </div>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-base font-bold text-gray-700 mb-2">Target Recipients *</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="target_criteria[]" value="all_parishioners" {{ in_array('all_parishioners', old('target_criteria', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-base text-gray-700">All Parishioners</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="target_criteria[]" value="wanafunzi" {{ in_array('wanafunzi', old('target_criteria', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-base text-gray-700">Waumini Wanafunzi (Students)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="target_criteria[]" value="wafanyakazi" {{ in_array('wafanyakazi', old('target_criteria', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-base text-gray-700">Waumini Wafanyakazi (Workers)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="target_criteria[]" value="leaders" {{ in_array('leaders', old('target_criteria', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-base text-gray-700">Leaders</span>
                    </label>
                </div>
                @error('target_criteria')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('sms.approval.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-colors text-base">
                    Submit for Approval
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('char-count');
    
    messageTextarea.addEventListener('input', function() {
        charCount.textContent = this.value.length;
        if (this.value.length > 160) {
            charCount.classList.add('text-red-600');
        } else {
            charCount.classList.remove('text-red-600');
        }
    });
    
    // Initialize count
    charCount.textContent = messageTextarea.value.length;
</script>
@endsection

