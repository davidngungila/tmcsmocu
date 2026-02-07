@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Income Details</h1>
            <p class="text-gray-600 mt-1">View income transaction information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('finance.income.print', $income->id) }}" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Print Receipt</span>
            </a>
            <a href="{{ route('finance.income.pdf', $income->id) }}" target="_blank" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Download PDF</span>
            </a>
            <a href="{{ route('finance.income.edit', $income->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('finance.income.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold">
                Back
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                    <div>
                        <p class="text-sm font-medium text-green-700">Amount</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">TZS {{ number_format($income->amount, 2) }}</p>
                    </div>
                    <div class="w-16 h-16 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                <p class="text-base font-bold text-gray-900">{{ $income->title }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-green-100 text-green-800">
                    {{ ucfirst(str_replace('_', ' ', $income->category)) }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Transaction Date</label>
                <p class="text-base font-medium text-gray-900">{{ $income->transaction_date->format('F d, Y') }}</p>
                <p class="text-sm text-gray-500">{{ $income->transaction_date->format('l, h:i A') }}</p>
            </div>
            
            @if($income->reference_number)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Reference Number</label>
                <p class="text-base font-medium text-gray-900">{{ $income->reference_number }}</p>
            </div>
            @endif
            
            @if($income->description)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                <p class="text-base text-gray-900">{{ $income->description }}</p>
            </div>
            @endif
            
            @if($income->notes)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
                <p class="text-base text-gray-900">{{ $income->notes }}</p>
            </div>
            @endif
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded By</label>
                <p class="text-base font-medium text-gray-900">{{ $income->creator->name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded At</label>
                <p class="text-base font-medium text-gray-900">{{ $income->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

