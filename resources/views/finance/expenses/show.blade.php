@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Expense Details</h1>
            <p class="text-gray-600 mt-1">View expense transaction information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('finance.expenses.edit', $expense->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('finance.expenses.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold">
                Back
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                    <div>
                        <p class="text-sm font-medium text-red-700">Amount</p>
                        <p class="text-3xl font-bold text-red-900 mt-2">TZS {{ number_format($expense->amount, 2) }}</p>
                    </div>
                    <div class="w-16 h-16 bg-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Title</label>
                <p class="text-base font-bold text-gray-900">{{ $expense->title }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Category</label>
                <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-red-100 text-red-800">
                    {{ ucfirst(str_replace('_', ' ', $expense->category)) }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Transaction Date</label>
                <p class="text-base font-medium text-gray-900">{{ $expense->transaction_date->format('F d, Y') }}</p>
                <p class="text-sm text-gray-500">{{ $expense->transaction_date->format('l, h:i A') }}</p>
            </div>
            
            @if($expense->reference_number)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Reference Number</label>
                <p class="text-base font-medium text-gray-900">{{ $expense->reference_number }}</p>
            </div>
            @endif
            
            @if($expense->description)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Description</label>
                <p class="text-base text-gray-900">{{ $expense->description }}</p>
            </div>
            @endif
            
            @if($expense->notes)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
                <p class="text-base text-gray-900">{{ $expense->notes }}</p>
            </div>
            @endif
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded By</label>
                <p class="text-base font-medium text-gray-900">{{ $expense->creator->name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded At</label>
                <p class="text-base font-medium text-gray-900">{{ $expense->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

