@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Financial Years</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage financial years and transitions</p>
        </div>
        <div class="flex gap-2">
            <button onclick="toggleBulkActions()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Bulk Actions
            </button>
            <a href="{{ route('settings.financial-years.create') }}" 
               class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Year
            </a>
        </div>
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 sm:p-6 border border-purple-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-purple-700">Total Years</p>
                    <p class="text-xl sm:text-2xl font-bold text-purple-900 mt-2">{{ $financialYears->total() }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 sm:p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-green-700">Active Year</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-900 mt-2">{{ $activeYear ? $activeYear->name : 'None' }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 sm:p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-700">Closed Years</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900 mt-2">{{ \App\Models\FinancialYear::where('is_closed', true)->count() }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 sm:p-6 border border-yellow-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-yellow-700">Pending Years</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-900 mt-2">{{ \App\Models\FinancialYear::where('is_closed', false)->where('is_active', false)->count() }}</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Year Info with Enhanced Details -->
    @if($activeYear)
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-purple-900">Current Financial Year</h3>
                <p class="text-purple-700 mt-1 text-xl">{{ $activeYear->name }}</p>
                <p class="text-sm text-purple-600 mt-1">
                    {{ $activeYear->start_date->format('d M Y') }} - {{ $activeYear->end_date->format('d M Y') }}
                </p>
                @if($activeYear->notes)
                <p class="text-sm text-purple-600 mt-2 italic">{{ $activeYear->notes }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <div class="text-center">
                    <p class="text-xs text-purple-600">Days Remaining</p>
                    <p class="text-lg font-bold text-purple-900">{{ max(0, $activeYear->end_date->diffInDays(now())) }}</p>
                </div>
                <span class="bg-purple-600 text-white px-4 py-2 rounded-lg font-bold">ACTIVE</span>
            </div>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-center justify-between">
            <p class="text-yellow-800">No financial year is set as active. Please set one year as active.</p>
            <a href="{{ route('settings.financial-years.create') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm">
                Create First Year
            </a>
        </div>
    </div>
    @endif

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <form method="GET" action="{{ route('settings.financial-years.index') }}" class="flex flex-col lg:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or notes..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm sm:text-base">
            </div>
            <div class="sm:w-48 lg:w-auto">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Not Started</option>
                </select>
            </div>
            <div class="sm:w-48 lg:w-auto">
                <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm sm:text-base">
                    <option value="">All Years</option>
                    @foreach(\App\Models\FinancialYear::selectRaw('YEAR(start_date) as year')->distinct()->orderBy('year', 'desc')->get() as $year)
                    <option value="{{ $year->year }}" {{ request('year') == $year->year ? 'selected' : '' }}>
                        {{ $year->year }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold text-sm sm:text-base">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'year']))
                <a href="{{ route('settings.financial-years.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium text-sm sm:text-base">
                    Clear
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bulk Actions Panel -->
    <div id="bulkActionsPanel" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                <span class="text-sm text-gray-500" id="selectedCount">0 selected</span>
            </div>
            <div class="flex gap-2">
                <button onclick="bulkAction('activate')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
                    Set Active
                </button>
                <button onclick="bulkAction('close')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm">
                    Close
                </button>
                <button onclick="bulkAction('delete')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Financial Years List with Enhanced Features -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="bulkSelect" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($financialYears as $year)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="year-checkbox w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" value="{{ $year->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $year->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">ID: {{ $year->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $year->start_date->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">to {{ $year->end_date->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $year->start_date->diffInDays($year->end_date) }} days</div>
                            <div class="text-xs text-gray-500">{{ $year->start_date->format('Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($year->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1 inline-block"></span>
                                    Active
                                </span>
                            @elseif($year->is_closed)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <span class="w-2 h-2 bg-gray-500 rounded-full mr-1 inline-block"></span>
                                    Closed
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1 inline-block"></span>
                                    Not Started
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $year->notes ?? 'No notes' }}">
                                {{ $year->notes ?? 'No notes' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-1">
                                @if(!$year->is_active && !$year->is_closed)
                                <form action="{{ route('settings.financial-years.set-active', $year->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900 font-medium text-xs px-2 py-1 rounded hover:bg-purple-50 transition" title="Set Active">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                
                                <a href="{{ route('settings.financial-years.transition', $year->id) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs px-2 py-1 rounded hover:bg-blue-50 transition" title="Transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4"></path>
                                    </svg>
                                </a>
                                
                                <a href="{{ route('settings.financial-years.edit', $year->id) }}" class="text-gray-600 hover:text-gray-900 font-medium text-xs px-2 py-1 rounded hover:bg-gray-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                @if(!$year->is_closed && !$year->is_active)
                                <form action="{{ route('settings.financial-years.close', $year->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to close this financial year?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs px-2 py-1 rounded hover:bg-red-50 transition" title="Close">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm">No financial years yet.</p>
                            <a href="{{ route('settings.financial-years.create') }}" class="text-purple-600 hover:underline font-medium">Add the first year</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($financialYears->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $financialYears->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleBulkActions() {
    const panel = document.getElementById('bulkActionsPanel');
    const bulkSelect = document.getElementById('bulkSelect');
    panel.classList.toggle('hidden');
    if (!panel.classList.contains('hidden')) {
        bulkSelect.checked = false;
        updateSelectedCount();
    }
}

document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.year-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

document.querySelectorAll('.year-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const checked = document.querySelectorAll('.year-checkbox:checked');
    document.getElementById('selectedCount').textContent = `${checked.length} selected`;
    document.getElementById('selectAll').checked = checked.length === document.querySelectorAll('.year-checkbox').length;
}

function bulkAction(action) {
    const checked = document.querySelectorAll('.year-checkbox:checked');
    if (checked.length === 0) {
        alert('Please select at least one financial year.');
        return;
    }
    
    const ids = Array.from(checked).map(cb => cb.value);
    
    if (action === 'delete' && !confirm(`Are you sure you want to delete ${ids.length} financial year(s)?`)) {
        return;
    }
    
    // Implement bulk action logic here
    console.log(`Bulk ${action} for years:`, ids);
    
    // For now, just show a message
    alert(`Bulk ${action} functionality would be implemented here for ${ids.length} year(s).`);
}
</script>
@endsection
