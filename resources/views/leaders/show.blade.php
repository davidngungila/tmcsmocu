@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $leader->parishioner->full_name ?? 'Leader Details' }}</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ $leader->position }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('leaders.edit', $leader->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('leaders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <!-- Status Badge -->
    <div class="flex items-center gap-4">
        <span class="inline-block px-4 py-2 text-sm font-bold rounded-full {{ $leader->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $leader->is_active ? 'Active Leader' : 'Inactive Leader' }}
        </span>
        @if($leader->end_date && $leader->end_date->isFuture())
            <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-blue-100 text-blue-800">
                Term Ends: {{ $leader->end_date->format('M d, Y') }}
            </span>
        @elseif($leader->end_date)
            <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-gray-100 text-gray-800">
                Term Ended: {{ $leader->end_date->format('M d, Y') }}
            </span>
        @endif
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Leader Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Leader Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->parishioner->full_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Position</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->position }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Start Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->start_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $leader->start_date->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">End Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->end_date ? $leader->end_date->format('M d, Y') : 'Ongoing' }}</p>
                        @if($leader->end_date)
                            <p class="text-xs text-gray-500 mt-1">{{ $leader->end_date->diffForHumans() }}</p>
                        @endif
                    </div>
                    @if($leader->responsibilities)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Responsibilities</label>
                        <div class="bg-gray-50 p-4 rounded-lg mt-2">
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $leader->responsibilities }}</p>
                        </div>
                    </div>
                    @endif
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Tenure Duration</label>
                        <p class="text-base font-bold text-gray-900">
                            @if($leader->end_date)
                                {{ $leader->start_date->diffInDays($leader->end_date) }} days
                                ({{ $leader->start_date->diffInMonths($leader->end_date) }} months)
                            @else
                                {{ $leader->start_date->diffInDays(now()) }} days
                                ({{ $leader->start_date->diffInMonths(now()) }} months)
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Parishioner Details -->
            @if($leader->parishioner)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Parishioner Profile</h2>
                    <a href="{{ route('parishioners.show', $leader->parishioner->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-bold">
                        View Full Profile →
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Contact Number</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $leader->parishioner->contact_number ?? $leader->parishioner->phone ?? 'N/A' }}
                            @if($leader->parishioner->contact_number || $leader->parishioner->phone)
                                <a href="tel:{{ $leader->parishioner->contact_number ?? $leader->parishioner->phone }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                    📞 Call
                                </a>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $leader->parishioner->email ?? 'N/A' }}
                            @if($leader->parishioner->email)
                                <a href="mailto:{{ $leader->parishioner->email }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                    ✉️ Email
                                </a>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $leader->parishioner->type === 'wanafunzi' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $leader->parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }}
                        </span>
                    </div>
                    @if($leader->parishioner->date_of_birth)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $leader->parishioner->date_of_birth->format('M d, Y') }}
                            <span class="text-xs text-gray-500 ml-2">(Age: {{ $leader->parishioner->date_of_birth->age }} years)</span>
                        </p>
                    </div>
                    @endif
                    @if($leader->parishioner->gender)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <p class="text-base font-bold text-gray-900 capitalize">{{ $leader->parishioner->gender }}</p>
                    </div>
                    @endif
                    @if($leader->parishioner->address)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                        <p class="text-base text-gray-900">{{ $leader->parishioner->address }}</p>
                    </div>
                    @endif
                    @if($leader->parishioner->occupation)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Occupation</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->parishioner->occupation }}</p>
                    </div>
                    @endif
                    @if($leader->parishioner->registration_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                        <p class="text-base font-bold text-gray-900">{{ $leader->parishioner->registration_date->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Community Involvement -->
            @if($leader->parishioner && $leader->parishioner->communities->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Community Involvement</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($leader->parishioner->communities as $community)
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $community->name }}</h4>
                        @if($community->pivot->joined_date)
                            <p class="text-sm text-gray-600 mt-1">
                                Joined: {{ \Carbon\Carbon::parse($community->pivot->joined_date)->format('M d, Y') }}
                            </p>
                        @endif
                        <span class="inline-block mt-2 px-2 py-1 text-xs font-bold rounded-full {{ $community->pivot->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $community->pivot->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Apostolic Groups -->
            @if($leader->parishioner && $leader->parishioner->apostolicGroups->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Apostolic Groups</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($leader->parishioner->apostolicGroups as $group)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $group->name }}</h4>
                        @if($group->description)
                            <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($group->description, 100) }}</p>
                        @endif
                        @if($group->pivot->joined_date)
                            <p class="text-xs text-gray-500 mt-1">
                                Joined: {{ \Carbon\Carbon::parse($group->pivot->joined_date)->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Event Participation -->
            @if($leader->parishioner && $leader->parishioner->eventAttendances->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Event Participation</h2>
                <div class="space-y-3">
                    @foreach($leader->parishioner->eventAttendances->take(5) as $attendance)
                    <div class="border-l-4 border-green-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $attendance->event->title ?? 'Event' }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($attendance->checked_in_at)
                                Attended: {{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('M d, Y h:i A') }}
                            @else
                                Event Date: {{ $attendance->event->start_date->format('M d, Y') ?? 'N/A' }}
                            @endif
                        </p>
                    </div>
                    @endforeach
                    @if($leader->parishioner->eventAttendances->count() > 5)
                        <p class="text-sm text-gray-500 text-center mt-2">
                            And {{ $leader->parishioner->eventAttendances->count() - 5 }} more events...
                        </p>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Financial Contributions -->
            @php
                $contributions = \App\Models\FinanceTransaction::where('parishioner_id', $leader->parishioner->id ?? null)
                    ->where('type', 'income')
                    ->latest()
                    ->take(10)
                    ->get();
                $totalContributions = \App\Models\FinanceTransaction::where('parishioner_id', $leader->parishioner->id ?? null)
                    ->where('type', 'income')
                    ->sum('amount');
            @endphp
            @if($contributions->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Financial Contributions</h2>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Total Contributions</p>
                        <p class="text-lg font-bold text-green-600">TSh {{ number_format($totalContributions, 0) }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    @foreach($contributions as $contribution)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-bold text-gray-900">{{ $contribution->title }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $contribution->category ?? 'N/A' }} • {{ $contribution->transaction_date->format('M d, Y') }}
                            </p>
                        </div>
                        <p class="text-base font-bold text-green-600">TSh {{ number_format($contribution->amount, 0) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    @if($leader->parishioner && ($leader->parishioner->contact_number || $leader->parishioner->phone))
                    <a href="tel:{{ $leader->parishioner->contact_number ?? $leader->parishioner->phone }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-bold">
                        📞 Call Leader
                    </a>
                    @endif
                    @if($leader->parishioner && $leader->parishioner->email)
                    <a href="mailto:{{ $leader->parishioner->email }}" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center font-bold">
                        ✉️ Send Email
                    </a>
                    @endif
                    @if($leader->parishioner && ($leader->parishioner->contact_number || $leader->parishioner->phone))
                    <a href="{{ route('sms.create') }}?phone={{ $leader->parishioner->contact_number ?? $leader->parishioner->phone }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center font-bold">
                        💬 Send SMS
                    </a>
                    @endif
                    <a href="{{ route('parishioners.show', $leader->parishioner->id) }}" class="block w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center font-bold">
                        👤 View Full Profile
                    </a>
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tenure Duration</label>
                        <p class="text-lg font-bold text-gray-900">
                            @if($leader->end_date)
                                {{ $leader->start_date->diffInMonths($leader->end_date) }} months
                            @else
                                {{ $leader->start_date->diffInMonths(now()) }} months
                            @endif
                        </p>
                    </div>
                    @if($leader->parishioner)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Communities</label>
                        <p class="text-lg font-bold text-gray-900">{{ $leader->parishioner->communities->count() }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Apostolic Groups</label>
                        <p class="text-lg font-bold text-gray-900">{{ $leader->parishioner->apostolicGroups->count() }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Events Attended</label>
                        <p class="text-lg font-bold text-gray-900">{{ $leader->parishioner->eventAttendances->count() }}</p>
                    </div>
                    @if($totalContributions > 0)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Total Contributions</label>
                        <p class="text-lg font-bold text-green-600">TSh {{ number_format($totalContributions, 0) }}</p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            
            <!-- Leader Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Leader Details</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created At</label>
                        <p class="text-sm font-bold text-gray-900">{{ $leader->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-sm font-bold text-gray-900">{{ $leader->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
