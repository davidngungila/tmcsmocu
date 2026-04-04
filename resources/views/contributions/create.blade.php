@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Record Contribution</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Add a new financial contribution from a parishioner</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="hidden sm:inline">Home > Finance > Contributions > Record</span>
            <span class="sm:hidden">Record Contribution</span>
        </div>
    </div>

    <!-- Contribution Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Contribution Details</h2>
            <p class="text-sm text-gray-600 mt-1">Fill in the contribution information below</p>
        </div>
        
        <form action="{{ route('finance.contributions.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Parishioner Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="parishioner_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Parishioner <span class="text-red-500">*</span>
                    </label>
                    <select id="parishioner_id" name="parishioner_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select a parishioner</option>
                        @foreach($parishioners as $parishioner)
                            <option value="{{ $parishioner->id }}"
                                    @if(old('parishioner_id') == $parishioner->id) selected @endif>
                                {{ $parishioner->full_name }} - {{ $parishioner->member_type }}
                            </option>
                        @endforeach
                    </select>
                    @error('parishioner_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Financial Year -->
                <div>
                    <label for="financial_year_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Financial Year
                    </label>
                    <select id="financial_year_id" name="financial_year_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select financial year (optional)</option>
                        @foreach($financialYears as $financialYear)
                            <option value="{{ $financialYear->id }}"
                                    @if(old('financial_year_id') == $financialYear->id) selected @endif
                                    @if($financialYear->is_active) selected @endif>
                                {{ $financialYear->name }} @if($financialYear->is_active) (Active) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('financial_year_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contribution Type and Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="contribution_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Contribution Type <span class="text-red-500">*</span>
                    </label>
                    <select id="contribution_type" name="contribution_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select contribution type</option>
                        @foreach(\App\Models\Contribution::TYPES as $type => $label)
                            <option value="{{ $type }}"
                                    @if(old('contribution_type') == $type) selected @endif>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('contribution_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Amount (TZS) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">TZS</span>
                        <input type="number" id="amount" name="amount" required
                               value="{{ old('amount') }}" min="0" step="0.01"
                               class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                               placeholder="0.00">
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contribution Date -->
            <div>
                <label for="contribution_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Contribution Date <span class="text-red-500">*</span>
                </label>
                <input type="date" id="contribution_date" name="contribution_date" required
                       value="{{ old('contribution_date', now()->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                @error('contribution_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                    Payment Method <span class="text-red-500">*</span>
                </label>
                <select id="payment_method" name="payment_method" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select payment method</option>
                    @foreach(\App\Models\Contribution::PAYMENT_METHODS as $method => $label)
                        <option value="{{ $method }}"
                                @if(old('payment_method') == $method) selected @endif>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reference Number (for bank transfers, mobile money, etc.) -->
            <div>
                <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Reference Number / Transaction ID
                </label>
                <input type="text" id="reference_number" name="reference_number"
                       value="{{ old('reference_number') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                       placeholder="e.g., Bank transaction ID, Mobile money reference">
                @error('reference_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Additional notes about this contribution">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 sm:flex-none px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Record Contribution
                    </span>
                </button>
                
                <a href="{{ route('finance.contributions.index') }}" class="flex-1 sm:flex-none px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Today's Total</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">TZS 125,000</p>
                </div>
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">This Week</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">TZS 485,000</p>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">This Month</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">TZS 1,850,000</p>
                </div>
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-700">Contributors</p>
                    <p class="text-2xl font-bold text-orange-900 mt-1">24</p>
                </div>
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
