@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Income</h1>
        <p class="text-gray-600 mt-1">Update income transaction details</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <form method="POST" action="{{ route('finance.income.update', $income->id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-base font-bold text-gray-700 mb-2">Category *</label>
                    <select id="category" name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="zaka" {{ $income->category === 'zaka' ? 'selected' : '' }}>Zaka</option>
                        <option value="sadaka" {{ $income->category === 'sadaka' ? 'selected' : '' }}>Sadaka</option>
                        <option value="fungu_la_kumi" {{ $income->category === 'fungu_la_kumi' ? 'selected' : '' }}>Fungu la Kumi</option>
                        <option value="michango_mingine" {{ $income->category === 'michango_mingine' ? 'selected' : '' }}>Michango Mingine</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="amount" class="block text-base font-bold text-gray-700 mb-2">Amount (TZS) *</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required value="{{ old('amount', $income->amount) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="title" class="block text-base font-bold text-gray-700 mb-2">Title *</label>
                <input type="text" id="title" name="title" required value="{{ old('title', $income->title) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="transaction_date" class="block text-base font-bold text-gray-700 mb-2">Transaction Date *</label>
                    <input type="date" id="transaction_date" name="transaction_date" required value="{{ old('transaction_date', $income->transaction_date->format('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="reference_number" class="block text-base font-bold text-gray-700 mb-2">Reference Number</label>
                    <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number', $income->reference_number) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-base font-bold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('description', $income->description) }}</textarea>
            </div>
            
            <div>
                <label for="notes" class="block text-base font-bold text-gray-700 mb-2">Notes</label>
                <textarea id="notes" name="notes" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('notes', $income->notes) }}</textarea>
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('finance.income.show', $income->id) }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-colors text-base shadow-sm">
                    Update Income
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

