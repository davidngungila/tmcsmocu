@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $parishioner->full_name }}</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                {{ $parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }} Parishioner
            </p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('parishioners.edit', $parishioner->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors text-sm sm:text-base">
                Edit
            </a>
            <a href="{{ route('parishioners.index', ['type' => $parishioner->type]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-bold text-sm sm:text-base">
                Back
            </a>
        </div>
    </div>
    
    <!-- Status Badge -->
    <div class="flex items-center gap-4">
        <span class="inline-block px-4 py-2 text-sm font-bold rounded-full {{ $parishioner->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $parishioner->is_active ? 'Active' : 'Inactive' }}
        </span>
        @if($currentYearStatus)
            <span class="inline-block px-4 py-2 text-sm font-bold rounded-full 
                {{ $currentYearStatus->status === 'new' ? 'bg-blue-100 text-blue-800' : 
                   ($currentYearStatus->status === 'graduated' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                {{ ucfirst($currentYearStatus->status) }} - {{ \App\Models\FinancialYear::getActive()->name ?? 'Current Year' }}
            </span>
        @endif
        @if($isLeader)
            <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-purple-100 text-purple-800">
                Leader
            </span>
        @endif
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Personal Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Type</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full {{ $parishioner->type === 'wanafunzi' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <p class="text-base font-bold text-gray-900 capitalize">{{ $parishioner->gender ?? 'N/A' }}</p>
                    </div>
                    @if($parishioner->date_of_birth)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $parishioner->date_of_birth->format('M d, Y') }}
                            <span class="text-xs text-gray-500 ml-2">(Age: {{ $parishioner->date_of_birth->age }} years)</span>
                        </p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $parishioner->registration_date ? $parishioner->registration_date->format('M d, Y') : 'N/A' }}
                            @if($parishioner->registration_date)
                                <span class="text-xs text-gray-500 ml-2">({{ $parishioner->registration_date->diffForHumans() }})</span>
                            @endif
                        </p>
                    </div>
                    @if($parishioner->occupation)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Occupation</label>
                        <p class="text-base font-bold text-gray-900">{{ $parishioner->occupation }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $parishioner->contact_number ?? $parishioner->phone ?? 'N/A' }}
                            @if($parishioner->contact_number || $parishioner->phone)
                                <a href="tel:{{ $parishioner->contact_number ?? $parishioner->phone }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                    📞 Call
                                </a>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-base font-bold text-gray-900">
                            {{ $parishioner->email ?? 'N/A' }}
                            @if($parishioner->email)
                                <a href="mailto:{{ $parishioner->email }}" class="ml-2 text-blue-600 hover:text-blue-900">
                                    ✉️ Email
                                </a>
                            @endif
                        </p>
                    </div>
                    @if($parishioner->address)
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                        <p class="text-base text-gray-900">{{ $parishioner->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Financial Year Status -->
            @if($currentYearStatus)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Financial Year Status</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-bold rounded-full 
                            {{ $currentYearStatus->status === 'new' ? 'bg-blue-100 text-blue-800' : 
                               ($currentYearStatus->status === 'graduated' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($currentYearStatus->status) }}
                        </span>
                    </div>
                    @if($currentYearStatus->joined_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Joined Date</label>
                        <p class="text-base font-bold text-gray-900">{{ \Carbon\Carbon::parse($currentYearStatus->joined_date)->format('M d, Y') }}</p>
                    </div>
                    @endif
                    @if($currentYearStatus->graduated_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Graduated Date</label>
                        <p class="text-base font-bold text-gray-900">{{ \Carbon\Carbon::parse($currentYearStatus->graduated_date)->format('M d, Y') }}</p>
                    </div>
                    @endif
                    @if($currentYearStatus->notes)
                    <div class="sm:col-span-3">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Notes</label>
                        <p class="text-sm text-gray-900">{{ $currentYearStatus->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Leader Positions -->
            @if($leaderPositions->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Leadership Positions</h2>
                <div class="space-y-3">
                    @foreach($leaderPositions as $position)
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $position->position }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $position->start_date->format('M d, Y') }} - 
                            {{ $position->end_date ? $position->end_date->format('M d, Y') : 'Ongoing' }}
                        </p>
                        @if($position->responsibilities)
                            <p class="text-sm text-gray-700 mt-2">{{ $position->responsibilities }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Community Involvement -->
            @if($activeCommunities->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Communities</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($activeCommunities as $community)
                    <div class="border-l-4 border-blue-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $community->name }}</h4>
                        @if($community->pivot->joined_date)
                            <p class="text-sm text-gray-600 mt-1">
                                Joined: {{ \Carbon\Carbon::parse($community->pivot->joined_date)->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Apostolic Groups -->
            @if($activeGroups->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Apostolic Groups</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($activeGroups as $group)
                    <div class="border-l-4 border-green-500 pl-4 py-2">
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
            @if($recentEvents->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Event Participation</h2>
                <div class="space-y-3">
                    @foreach($recentEvents as $attendance)
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <h4 class="font-bold text-gray-900">{{ $attendance->event->title ?? 'Event' }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($attendance->checked_in_at)
                                Attended: {{ \Carbon\Carbon::parse($attendance->checked_in_at)->format('M d, Y h:i A') }}
                            @elseif($attendance->event)
                                Event Date: {{ $attendance->event->start_date->format('M d, Y') ?? 'N/A' }}
                            @endif
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Financial Contributions -->
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
            
            <!-- Notes -->
            @if($parishioner->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Notes</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $parishioner->notes }}</p>
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
                    @if($parishioner->contact_number || $parishioner->phone)
                    <a href="tel:{{ $parishioner->contact_number ?? $parishioner->phone }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center font-bold">
                        📞 Call
                    </a>
                    @endif
                    @if($parishioner->email)
                    <a href="mailto:{{ $parishioner->email }}" class="block w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-center font-bold">
                        ✉️ Send Email
                    </a>
                    @endif
                    @if($parishioner->contact_number || $parishioner->phone)
                    <a href="{{ route('sms.create') }}?phone={{ $parishioner->contact_number ?? $parishioner->phone }}" class="block w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-center font-bold">
                        💬 Send SMS
                    </a>
                    @endif
                    @if($isLeader)
                    <a href="{{ route('leaders.index') }}?parishioner={{ $parishioner->id }}" class="block w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center font-bold">
                        👤 View Leadership
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Statistics</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Communities</label>
                        <p class="text-lg font-bold text-gray-900">{{ $communitiesCount }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Apostolic Groups</label>
                        <p class="text-lg font-bold text-gray-900">{{ $groupsCount }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Events Attended</label>
                        <p class="text-lg font-bold text-gray-900">{{ $eventsAttended }}</p>
                    </div>
                    @if($totalContributions > 0)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Total Contributions</label>
                        <p class="text-lg font-bold text-green-600">TSh {{ number_format($totalContributions, 0) }}</p>
                    </div>
                    @endif
                    @if($parishioner->date_of_birth)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Age</label>
                        <p class="text-lg font-bold text-gray-900">{{ $parishioner->date_of_birth->age }} years</p>
                    </div>
                    @endif
                    @if($parishioner->registration_date)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Member Since</label>
                        <p class="text-sm font-bold text-gray-900">{{ $parishioner->registration_date->format('M Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $parishioner->registration_date->diffForHumans() }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Parishioner Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Details</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Created At</label>
                        <p class="text-sm font-bold text-gray-900">{{ $parishioner->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-sm font-bold text-gray-900">{{ $parishioner->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
