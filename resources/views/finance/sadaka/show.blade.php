@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Offering Details</h1>
        </div>
        <a href="{{ route('finance.sadaka.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="space-y-4">
            <div>
                <label class="text-sm font-bold text-gray-500">Parishioner</label>
                <p class="text-lg text-gray-900">{{ $sadaka->parishioner ? $sadaka->parishioner->full_name : 'N/A' }}</p>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-500">Amount</label>
                <p class="text-lg text-gray-900">TSh {{ number_format($sadaka->amount, 0) }}</p>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-500">Date</label>
                <p class="text-lg text-gray-900">{{ $sadaka->transaction_date->format('d M Y') }}</p>
            </div>
            @if($sadaka->reference_number)
            <div>
                <label class="text-sm font-bold text-gray-500">Reference Number</label>
                <p class="text-lg text-gray-900">{{ $sadaka->reference_number }}</p>
            </div>
            @endif
            @if($sadaka->notes)
            <div>
                <label class="text-sm font-bold text-gray-500">Notes</label>
                <p class="text-lg text-gray-900">{{ $sadaka->notes }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
