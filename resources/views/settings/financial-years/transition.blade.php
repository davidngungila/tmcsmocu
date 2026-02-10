@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Transition Financial Year</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Transition from one year to another</p>
        </div>
        <a href="{{ route('settings.financial-years.index') }}" 
           class="text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="space-y-6">
            <!-- Current Year Info -->
            <div class="border-b pb-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Current Financial Year</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-semibold text-gray-900">{{ $oldYear->name }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $oldYear->start_date->format('d M Y') }} - {{ $oldYear->end_date->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- New Year Info -->
            <div class="border-b pb-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">New Financial Year</h3>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="font-semibold text-purple-900">{{ $newYear->name }}</p>
                    <p class="text-sm text-purple-700 mt-1">
                        {{ $newYear->start_date->format('d M Y') }} - {{ $newYear->end_date->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- Transition Summary -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-bold text-blue-900 mb-3">Transition Summary:</h4>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li>• Active parishioners in current year: <strong>{{ $activeParishioners }}</strong></li>
                    <li>• New parishioners to be added: <strong>{{ $newParishioners }}</strong></li>
                    <li>• Active parishioners will continue as "active" in the new year</li>
                    <li>• New parishioners will be set as "new" in the new year</li>
                </ul>
            </div>

            <!-- Warning -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Warning:</strong> This action will do the following:
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>All active parishioners in the current year will be marked as "graduated"</li>
                        <li>All active parishioners will be added to the new year</li>
                        <li>The new year will be set as the current financial year (active)</li>
                    </ul>
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('settings.financial-years.transition.store', $newYear->id) }}" 
                  onsubmit="return confirm('Are you sure you want to proceed with this transition? This action cannot be undone.');">
                @csrf
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('settings.financial-years.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Proceed with Transition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
