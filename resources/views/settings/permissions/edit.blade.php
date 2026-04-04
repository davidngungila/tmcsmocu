@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('settings.permissions.index') }}" class="text-gray-600 hover:text-gray-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manage Permissions: {{ $role->display_name ?? $role->name }}</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">{{ $role->description }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="previewPermissions()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Preview</span>
            </button>
            <button onclick="resetToDefault()" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Reset to Default</span>
            </button>
        </div>
    </div>

    <!-- Role Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center rounded-full bg-purple-100">
                    <span class="text-purple-600 font-bold text-xl">{{ substr($role->name, 0, 2) }}</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $role->display_name ?? $role->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $role->slug }}</p>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Access Level</p>
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($role->level === 'super_admin') bg-red-100 text-red-800
                    @elseif($role->level === 'leadership') bg-blue-100 text-blue-800
                    @elseif($role->level === 'standard') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $role->level ?? 'standard')) }}
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Assigned Users</p>
                <p class="text-xl font-bold text-blue-600">{{ $role->users_count ?? 0 }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Current Permissions</p>
                <p class="text-xl font-bold text-purple-600">{{ $rolePermissions->count() }}</p>
            </div>
        </div>
        @if($role->responsibilities)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm font-medium text-gray-600 mb-2">Responsibilities</p>
            <p class="text-gray-700">{{ $role->responsibilities }}</p>
        </div>
        @endif
    </div>

    <!-- Permissions Management Form -->
    <form method="POST" action="{{ route('settings.permissions.update', $role->id) }}" id="permissionsForm">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Core Modules -->
            @foreach($modulePermissions as $module => $permissions)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white rounded-lg shadow-sm">
                                @switch($module)
                                    @case('members')
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        @break
                                    @case('finance')
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @break
                                    @case('certificates')
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        @break
                                    @case('elections')
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        @break
                                    @default
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                @endswitch
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst($module) }}</h3>
                                <p class="text-sm text-gray-500">{{ $permissions->count() }} permissions available</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="toggleModule('{{ $module }}')" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Select All
                            </button>
                            <div class="h-4 w-px bg-gray-300"></div>
                            <button type="button" onclick="expandModule('{{ $module }}')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5 transform transition-transform module-chevron" id="chevron-{{ $module }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 space-y-4 module-permissions" id="module-{{ $module }}">
                    @foreach($permissions->groupBy('category') as $category => $categoryPermissions)
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">{{ $category }}</h4>
                        <div class="space-y-2">
                            @foreach($categoryPermissions as $permission)
                            <label class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors permission-item">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                    {{ $rolePermissions->contains($permission) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 permission-checkbox"
                                    data-module="{{ $module }}">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $permission->display_name }}</span>
                                            @if($permission->description)
                                            <p class="text-xs text-gray-500 mt-1">{{ $permission->description }}</p>
                                            @endif
                                        </div>
                                        @if($permission->category === 'admin')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Admin</span>
                                        @elseif($permission->category === 'write')
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Write</span>
                                        @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Read</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span id="selectedCount">{{ $rolePermissions->count() }}</span> of <span id="totalCount">{{ $allPermissions->count() }}</span> permissions selected
                </div>
                <div class="flex items-center space-x-3">
                    <button type="button" onclick="clearAll()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Clear All
                    </button>
                    <button type="button" onclick="selectAll()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        Select All
                    </button>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Save Permissions</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-xl bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Permission Preview</h3>
            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="previewContent">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Toggle module permissions
function toggleModule(module) {
    const checkboxes = document.querySelectorAll(`input[data-module="${module}"]`);
    const button = event.target;
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
    
    button.textContent = allChecked ? 'Select All' : 'Deselect All';
    updateSelectedCount();
}

// Expand/Collapse module
function expandModule(module) {
    const content = document.getElementById(`module-${module}`);
    const chevron = document.getElementById(`chevron-${module}`);
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        chevron.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'none';
        chevron.style.transform = 'rotate(-90deg)';
    }
}

// Select all permissions
function selectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateSelectedCount();
}

// Clear all permissions
function clearAll() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateSelectedCount();
}

// Update selected count
function updateSelectedCount() {
    const selected = document.querySelectorAll('.permission-checkbox:checked').length;
    const total = document.querySelectorAll('.permission-checkbox').length;
    document.getElementById('selectedCount').textContent = selected;
    document.getElementById('totalCount').textContent = total;
}

// Preview permissions
function previewPermissions() {
    const modal = document.getElementById('previewModal');
    const content = document.getElementById('previewContent');
    const selectedPermissions = Array.from(document.querySelectorAll('.permission-checkbox:checked'))
        .map(cb => cb.closest('.permission-item').querySelector('.font-medium').textContent);
    
    content.innerHTML = `
        <div class="space-y-4">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h4 class="font-semibold text-purple-900 mb-2">Selected Permissions Summary</h4>
                <p class="text-purple-700">${selectedPermissions.length} permissions selected for this role</p>
            </div>
            <div class="max-h-96 overflow-y-auto">
                <div class="space-y-2">
                    ${selectedPermissions.map(permission => `
                        <div class="flex items-center space-x-2 p-2 bg-gray-50 rounded">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm text-gray-700">${permission}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
    `;
    
    modal.style.display = 'block';
}

// Close preview modal
function closePreviewModal() {
    document.getElementById('previewModal').style.display = 'none';
}

// Reset to default
function resetToDefault() {
    if (confirm('Are you sure you want to reset permissions to the default configuration for this role? This will clear all current selections.')) {
        // Implement reset logic based on role level
        const roleLevel = '{{ $role->level ?? "standard" }}';
        // This would typically make an AJAX call to get default permissions
        location.reload();
    }
}

// Update count on checkbox change
document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

// Initialize
updateSelectedCount();
</script>
@endpush
