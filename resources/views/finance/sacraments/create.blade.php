@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add Sacrament Sale</h1>
        <p class="text-gray-600 mt-1">Record a new sacrament sale</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('finance.sacraments.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sacrament_type" class="block text-base font-bold text-gray-700 mb-2">Sacrament Type *</label>
                    <select id="sacrament_type" name="sacrament_type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="">Select Type</option>
                        <option value="ubatizo">Ubatizo</option>
                        <option value="kipaimara">Kipaimara</option>
                        <option value="ndoa">Ndoa</option>
                        <option value="misa_maalum">Misa Maalum</option>
                    </select>
                    @error('sacrament_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="amount" class="block text-base font-bold text-gray-700 mb-2">Amount (TZS) *</label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" required value="{{ old('amount') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block text-base font-bold text-gray-700 mb-2">Customer Name *</label>
                    <input type="text" id="customer_name" name="customer_name" required value="{{ old('customer_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="phone" class="block text-base font-bold text-gray-700 mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                </div>
            </div>
            
            <div>
                <label for="sale_date" class="block text-base font-bold text-gray-700 mb-2">Sale Date *</label>
                <input type="date" id="sale_date" name="sale_date" required value="{{ old('sale_date', date('Y-m-d')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                @error('sale_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="notes" class="block text-base font-bold text-gray-700 mb-2">Notes</label>
                <textarea id="notes" name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('notes') }}</textarea>
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('finance.sacraments.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-colors text-base">
                    Save Sale
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

