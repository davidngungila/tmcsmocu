@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Financial Years</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage financial years and transitions</p>
        </div>
        <a href="{{ route('settings.financial-years.create') }}" 
           class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
            + Add New Year
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <!-- Active Year Info -->
    @if($activeYear)
    <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-purple-900">Current Financial Year</h3>
                <p class="text-purple-700 mt-1">{{ $activeYear->name }}</p>
                <p class="text-sm text-purple-600 mt-1">
                    {{ $activeYear->start_date->format('d M Y') }} - {{ $activeYear->end_date->format('d M Y') }}
                </p>
            </div>
            <span class="bg-purple-600 text-white px-4 py-2 rounded-lg font-bold">ACTIVE</span>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <p class="text-yellow-800">No financial year is set as active. Please set one year as active.</p>
    </div>
    @endif

    <!-- Financial Years List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($financialYears as $year)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $year->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $year->start_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $year->end_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($year->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @elseif($year->is_closed)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Closed</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Not Started</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            @if(!$year->is_active && !$year->is_closed)
                                <form action="{{ route('settings.financial-years.set-active', $year->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900">Set Active</button>
                                </form>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('settings.financial-years.transition', $year->id) }}" class="text-blue-600 hover:text-blue-900">Transition</a>
                            @endif
                            @if($year->is_active)
                                <a href="{{ route('settings.financial-years.transition', $year->id) }}" class="text-blue-600 hover:text-blue-900">Transition</a>
                            @endif
                            @if(!$year->is_closed && !$year->is_active)
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('settings.financial-years.close', $year->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to close this financial year?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">Close</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No financial years yet. <a href="{{ route('settings.financial-years.create') }}" class="text-purple-600 hover:underline">Add the first year</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
