@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Record Tithe (Zaka)</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Record tithe contribution from parishioner</p>
        </div>
        <a href="{{ route('finance.zaka.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('finance.zaka.store') }}" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Parishioner *</label>
                <select name="parishioner_id" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Select Parishioner</option>
                    @foreach($parishioners as $parishioner)
                        <option value="{{ $parishioner->id }}" {{ old('parishioner_id') == $parishioner->id ? 'selected' : '' }}>
                            {{ $parishioner->full_name }} 
                            @if($parishioner->phone)
                                - {{ $parishioner->phone }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('parishioner_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Amount (TSh) *</label>
                    <input type="number" name="amount" step="0.01" min="0" required value="{{ old('amount') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('amount')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Date *</label>
                    <input type="date" name="transaction_date" required value="{{ old('transaction_date', date('Y-m-d')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('transaction_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Reference Number (Optional)</label>
                <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('notes') }}</textarea>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    <strong>Note:</strong> A thank you message will be sent to the parishioner via SMS if their phone number is registered.
                </p>
            </div>

            <div class="flex justify-end space-x-4 pt-4">
                <a href="{{ route('finance.zaka.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    Save Tithe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
