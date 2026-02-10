@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Tithe Details</h1>
        </div>
        <a href="{{ route('finance.zaka.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="space-y-4">
            <div>
                <label class="text-sm font-bold text-gray-500">Parishioner</label>
                <p class="text-lg text-gray-900">{{ $zaka->parishioner ? $zaka->parishioner->full_name : 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-500">Amount</label>
                <p class="text-lg text-gray-900">TSh {{ number_format($zaka->amount, 0) }}</p>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-500">Date</label>
                <p class="text-lg text-gray-900">{{ $zaka->transaction_date->format('d M Y') }}</p>
            </div>
            @if($zaka->reference_number)
            <div>
                <label class="text-sm font-bold text-gray-500">Reference Number</label>
                <p class="text-lg text-gray-900">{{ $zaka->reference_number }}</p>
            </div>
            @endif
            @if($zaka->notes)
            <div>
                <label class="text-sm font-bold text-gray-500">Notes</label>
                <p class="text-lg text-gray-900">{{ $zaka->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
