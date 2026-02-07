@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Add Asset</h1>
        <p class="text-gray-600 mt-1">Register a new asset</p>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('assets.store') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-base font-bold text-gray-700 mb-2">Asset Name *</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="category" class="block text-base font-bold text-gray-700 mb-2">Category *</label>
                    <select id="category" name="category" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="">Select Category</option>
                        <option value="majengo">Majengo</option>
                        <option value="vifaa">Vifaa</option>
                        <option value="samani">Samani</option>
                        <option value="vifaa_vya_ibada">Vifaa vya Ibada</option>
                        <option value="nyingine">Nyingine</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-base font-bold text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('description') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="value" class="block text-base font-bold text-gray-700 mb-2">Value (TZS)</label>
                    <input type="number" id="value" name="value" step="0.01" min="0" value="{{ old('value') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                </div>
                
                <div>
                    <label for="status" class="block text-base font-bold text-gray-700 mb-2">Status *</label>
                    <select id="status" name="status" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                        <option value="inayotumika">Inayotumika</option>
                        <option value="iliyoharibika">Iliyoharibika</option>
                        <option value="inayohitaji_matengenezo">Inayohitaji Matengenezo</option>
                        <option value="imepotea">Imepotea</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="acquisition_date" class="block text-base font-bold text-gray-700 mb-2">Acquisition Date</label>
                    <input type="date" id="acquisition_date" name="acquisition_date" value="{{ old('acquisition_date') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                </div>
                
                <div>
                    <label for="location" class="block text-base font-bold text-gray-700 mb-2">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">
                </div>
            </div>
            
            <div>
                <label for="maintenance_notes" class="block text-base font-bold text-gray-700 mb-2">Maintenance Notes</label>
                <textarea id="maintenance_notes" name="maintenance_notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-base">{{ old('maintenance_notes') }}</textarea>
            </div>
            
            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('assets.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors text-base font-bold">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg font-bold hover:bg-purple-700 transition-colors text-base">
                    Save Asset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

