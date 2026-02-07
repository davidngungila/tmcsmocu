@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Sacrament Sale Details</h1>
            <p class="text-gray-600 mt-1">View sacrament sale information</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('finance.sacraments.edit', $sacrament->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('finance.sacraments.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold">
                Back
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div>
                        <p class="text-sm font-medium text-purple-700">Sale Amount</p>
                        <p class="text-3xl font-bold text-purple-900 mt-2">TZS {{ number_format($sacrament->amount, 2) }}</p>
                    </div>
                    <div class="w-16 h-16 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Sacrament Type</label>
                <span class="inline-block px-3 py-1 text-sm font-bold rounded-full bg-purple-100 text-purple-800">
                    {{ ucfirst(str_replace('_', ' ', $sacrament->sacrament_type)) }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Sale Date</label>
                <p class="text-base font-medium text-gray-900">{{ $sacrament->sale_date->format('F d, Y') }}</p>
                <p class="text-sm text-gray-500">{{ $sacrament->sale_date->format('l') }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Customer Name</label>
                <p class="text-base font-bold text-gray-900">{{ $sacrament->customer_name }}</p>
            </div>
            
            @if($sacrament->phone)
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                <p class="text-base font-medium text-gray-900">{{ $sacrament->phone }}</p>
            </div>
            @endif
            
            @if($sacrament->notes)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
                <p class="text-base text-gray-900">{{ $sacrament->notes }}</p>
            </div>
            @endif
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded By</label>
                <p class="text-base font-medium text-gray-900">{{ $sacrament->creator->name ?? 'N/A' }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Recorded At</label>
                <p class="text-base font-medium text-gray-900">{{ $sacrament->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

