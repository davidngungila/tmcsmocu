@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Generate Group Certificates</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Select parishioners and generate group certificates in bulk</p>
        </div>
        <a href="{{ route('certificates.log') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            ← Certificate Log
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

    <!-- Group Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Group Information</h2>
        
        <form action="{{ route('certificates.group.store') }}" method="POST" id="certificateForm">
            @csrf
            
            <!-- Group Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Group Name</label>
                <input type="text" name="group_name" required 
                       placeholder="e.g., St. Mary's Youth Group"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <!-- Template Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Certificate Template</label>
                <select name="template_name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Select a template</option>
                    <option value="modern_group">Modern Group Certificate</option>
                    <option value="traditional">Traditional Certificate</option>
                    <option value="achievement">Achievement Certificate</option>
                    <option value="choir_standard">Choir Certificate</option>
                    <option value="legion_mary_standard">Legion of Mary Certificate</option>
                    <option value="charismatic_standard">Charismatic Renewal Certificate</option>
                    <option value="altar_servers_standard">Altar Servers Certificate</option>
                    <option value="catechists_standard">Catechists Certificate</option>
                    <option value="youth_standard">Youth Ministry Certificate</option>
                    <option value="leadership_chairperson">Community Chairperson Certificate</option>
                    <option value="leadership_group">Group Leader Certificate</option>
                    <option value="leadership_event">Event Chairperson Certificate</option>
                </select>
            </div>

            <!-- Issue Date -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Issue Date</label>
                <input type="date" name="issue_date" required 
                       value="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea name="description" rows="3" 
                          placeholder="e.g., For outstanding community service during the 2026 parish outreach program"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"></textarea>
            </div>
        </div>

        <!-- Parishioner Selection -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Select Group Members</h2>
            
            <!-- Search and Filter -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Parishioners</label>
                    <input type="text" id="searchInput" placeholder="Search by name, registration number, or phone..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Type</label>
                    <select id="typeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Types</option>
                        <option value="student">Students</option>
                        <option value="employee">Employees</option>
                        <option value="child">Children</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Academic Programme</label>
                    <select id="programmeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Programmes</option>
                        <option value="BBICT">BBICT</option>
                        <option value="BAPSM">BAPSM</option>
                        <option value="LL.B">LL.B</option>
                        <option value="BHRM">BHRM</option>
                        <option value="BBA">BBA</option>
                        <option value="BED">BED</option>
                    </select>
                </div>
            </div>

            <!-- Selection Actions -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="selectAll" class="mr-2">
                        <span class="text-sm font-medium text-gray-700">Select All</span>
                    </label>
                    <span class="text-sm text-gray-500">
                        <span id="selectedCount">0</span> selected
                    </span>
                </div>
                <button type="button" id="clearSelection" 
                        class="text-sm text-red-600 hover:text-red-700 font-medium">
                    Clear Selection
                </button>
            </div>

            <!-- Parishioner List -->
            <div class="border border-gray-200 rounded-lg max-h-96 overflow-y-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Select
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Registration No
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Programme
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Phone
                            </th>
                        </tr>
                    </thead>
                    <tbody id="parishionerList" class="bg-white divide-y divide-gray-200">
                        @foreach($parishioners ?? [] as $parishioner)
                        <tr class="hover:bg-gray-50 parishioner-row" data-id="{{ $parishioner->id }}">
                            <td class="px-4 py-2">
                                <input type="checkbox" class="parishioner-checkbox" value="{{ $parishioner->id }}" 
                                       data-name="{{ $parishioner->full_name }}" data-type="{{ $parishioner->member_type ?? 'unknown' }}">
                            </td>
                            <td class="px-4 py-2">
                                <div class="text-sm font-medium text-gray-900">{{ $parishioner->full_name }}</div>
                                @if($parishioner->date_of_birth)
                                    <div class="text-xs text-gray-500">{{ $parishioner->date_of_birth->format('Y-m-d') }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $parishioner->member_type === 'student' ? 'bg-blue-100 text-blue-800' : 
                                      ($parishioner->member_type === 'employee' ? 'bg-green-100 text-green-800' : 
                                      ($parishioner->member_type === 'child' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($parishioner->member_type ?? 'Unknown') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $parishioner->registration_number ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $parishioner->academic_programme ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $parishioner->phone ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submit Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <!-- Selected Members (Hidden) -->
            <input type="hidden" name="selected_parishioners" id="selectedParishioners" value="">
            
            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" id="generateBtn" disabled
                        class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Generate Group Certificates
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Parishioner selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const programmeFilter = document.getElementById('programmeFilter');
    const selectAllCheckbox = document.getElementById('selectAll');
    const clearSelectionBtn = document.getElementById('clearSelection');
    const selectedCountSpan = document.getElementById('selectedCount');
    const selectedParishionersInput = document.getElementById('selectedParishioners');
    const generateBtn = document.getElementById('generateBtn');
    const parishionerRows = document.querySelectorAll('.parishioner-row');
    
    // Update selected count and form
    function updateSelection() {
        const checkboxes = document.querySelectorAll('.parishioner-checkbox:checked');
        const selectedCount = checkboxes.length;
        selectedCountSpan.textContent = selectedCount;
        
        // Update hidden input
        const selectedIds = Array.from(checkboxes).map(cb => cb.value);
        selectedParishionersInput.value = selectedIds.join(',');
        
        // Enable/disable generate button
        generateBtn.disabled = selectedCount === 0;
        
        // Update select all checkbox state
        const totalCheckboxes = document.querySelectorAll('.parishioner-checkbox');
        selectAllCheckbox.checked = selectedCount === totalCheckboxes.length && selectedCount > 0;
    }
    
    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.parishioner-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelection();
    });
    
    // Clear selection
    clearSelectionBtn.addEventListener('click', function() {
        document.querySelectorAll('.parishioner-checkbox').forEach(cb => cb.checked = false);
        updateSelection();
    });
    
    // Individual checkbox changes
    document.querySelectorAll('.parishioner-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelection);
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        parishionerRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    
    // Type filter
    typeFilter.addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        parishionerRows.forEach(row => {
            const typeCell = row.querySelector('td:nth-child(3)');
            const type = typeCell.textContent.toLowerCase();
            row.style.display = filterValue === '' || type.includes(filterValue) ? '' : 'none';
        });
    });
    
    // Programme filter
    programmeFilter.addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        parishionerRows.forEach(row => {
            const programmeCell = row.querySelector('td:nth-child(5)');
            const programme = programmeCell.textContent.toLowerCase();
            row.style.display = filterValue === '' || programme.includes(filterValue) ? '' : 'none';
        });
    });
    
    // Initialize
    updateSelection();
});
</script>
@endsection
