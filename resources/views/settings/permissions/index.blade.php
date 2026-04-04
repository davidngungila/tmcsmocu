@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Roles & Permissions Management</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Comprehensive role-based access control system</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="refreshData()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Refresh</span>
            </button>
            <button onclick="exportRoles()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Export</span>
            </button>
            <button onclick="importRoles()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>Import</span>
            </button>
            <button onclick="openBulkActions()" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span>Bulk Actions</span>
            </button>
            <button onclick="openPermissionTemplates()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
                <span>Templates</span>
            </button>
            <button onclick="openNewRoleModal()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>New Role</span>
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Roles</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $roles->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Roles</p>
                    <p class="text-2xl font-bold text-green-600">{{ $roles->where('is_active', true)->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $roles->sum('users_count') }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Modules</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $modulesCount ?? 12 }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Grid Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-3">
                <h2 class="text-lg font-semibold text-gray-800">Roles Overview</h2>
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" id="roleSearch" placeholder="Search roles..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent w-full sm:w-auto">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <!-- Filter -->
                    <select id="levelFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Levels</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="leadership">Leadership</option>
                        <option value="standard">Standard</option>
                        <option value="limited">Limited</option>
                    </select>
                    <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="overflow-x-auto -mx-4 px-4">
            <table class="w-full min-w-[800px]" id="rolesTable">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-purple-600">
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 min-w-[150px]" onclick="sortTable('name')">
                            Role
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell min-w-[100px]">Level</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell min-w-[80px]">Users</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell min-w-[100px]">Permissions</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell min-w-[80px]">Status</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $role)
                    <tr class="hover:bg-gray-50 role-row" data-level="{{ $role->level ?? 'standard' }}" data-status="{{ $role->is_active ?? '1' }}" data-name="{{ $role->name }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="role-checkbox rounded border-gray-300 text-purple-600" value="{{ $role->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-purple-100">
                                    <span class="text-purple-600 font-semibold">{{ substr($role->name, 0, 2) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $role->display_name ?? $role->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $role->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if(($role->level ?? 'standard') === 'super_admin') bg-red-100 text-red-800
                                @elseif(($role->level ?? 'standard') === 'leadership') bg-blue-100 text-blue-800
                                @elseif(($role->level ?? 'standard') === 'standard') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $role->level ?? 'standard')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $role->users_count ?? 0 }}</div>
                            <div class="text-xs text-gray-500">assigned users</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-purple-600">{{ count($role->permissions ?? []) }}</span>
                                <button onclick="managePermissions({{ $role->id }})" class="text-purple-600 hover:text-purple-800 text-sm underline">
                                    Manage
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($role->is_active ?? true) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ($role->is_active ?? true) ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex flex-wrap gap-1 items-center justify-center">
                                <button onclick="managePermissions({{ $role->id }})" class="text-purple-600 hover:text-purple-900 p-1 rounded hover:bg-purple-50" title="Manage Permissions">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </button>
                                <button onclick="viewPermissionSummary({{ $role->id }})" class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50" title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                                <button onclick="cloneRole({{ $role->id }})" class="text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50" title="Clone Role">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                                <button onclick="toggleRoleStatus({{ $role->id }})" class="text-yellow-600 hover:text-yellow-900 p-1 rounded hover:bg-yellow-50" title="Toggle Status">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </button>
                                @if(($role->users_count ?? 0) == 0)
                                <button onclick="deleteRole({{ $role->id }}, '{{ $role->display_name ?? $role->name }}')" class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50" title="Delete Role">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($roles->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        <p class="text-gray-500 text-base">No roles found. Create your first role to get started.</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Search functionality
document.getElementById('roleSearch').addEventListener('input', function(e) {
    filterTable();
});

// Filter functionality
document.getElementById('levelFilter').addEventListener('change', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const searchTerm = document.getElementById('roleSearch').value.toLowerCase();
    const levelFilter = document.getElementById('levelFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#rolesTable .role-row');
    
    rows.forEach(row => {
        const name = row.dataset.name.toLowerCase();
        const level = row.dataset.level;
        const status = row.dataset.status;
        
        const matchesSearch = name.includes(searchTerm);
        const matchesLevel = !levelFilter || level === levelFilter;
        const matchesStatus = !statusFilter || status === statusFilter;
        
        row.style.display = matchesSearch && matchesLevel && matchesStatus ? '' : 'none';
    });
}

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.role-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

function managePermissions(roleId) {
    window.location.href = `/settings/permissions/${roleId}/edit`;
}

function sortTable(column) {
    // Implementation for sorting
    console.log('Sorting by:', column);
}

// Export roles functionality
function exportRoles() {
    // Create CSV content
    let csvContent = "Name,Display Name,Level,Users,Permissions,Status\n";
    
    const rows = document.querySelectorAll('#rolesTable .role-row');
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            const name = row.dataset.name;
            const displayName = row.dataset.displayName;
            const level = row.dataset.level;
            const users = row.dataset.users;
            const permissions = row.dataset.permissions;
            const status = row.dataset.status;
            
            csvContent += `"${name}","${displayName}","${level}","${users}","${permissions}","${status}"\n`;
        }
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'roles_export.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}

// Open new role modal
function openNewRoleModal() {
    // For now, redirect to a create role page (to be implemented)
    alert('Create role functionality will be implemented in the next version. For now, roles are managed through the comprehensive seeder.');
}

// Delete role functionality
function deleteRole(roleId, roleName) {
    if (confirm(`Are you sure you want to delete the role "${roleName}"? This action cannot be undone.`)) {
        // Make AJAX call to delete role
        fetch(`/settings/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting role: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the role.');
        });
    }
}

// Toggle role status
function toggleRoleStatus(roleId) {
    fetch(`/settings/roles/${roleId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error toggling role status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while toggling the role status.');
    });
}

// Refresh data
function refreshData() {
    location.reload();
}

// Import roles
function importRoles() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.csv,.json';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                try {
                    const data = event.target.result;
                    // For now, just show a success message
                    alert('Import functionality will be implemented in the next version. File loaded: ' + file.name);
                } catch (error) {
                    alert('Error reading file: ' + error.message);
                }
            };
            reader.readAsText(file);
        }
    };
    input.click();
}

// Open bulk actions modal
function openBulkActions() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    modal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Bulk Actions</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-4">
                    <button onclick="bulkActivate()" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Activate Selected Roles
                    </button>
                    <button onclick="bulkDeactivate()" class="w-full px-4 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        Deactivate Selected Roles
                    </button>
                    <button onclick="bulkDelete()" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Delete Selected Roles
                    </button>
                    <button onclick="bulkClone()" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Clone Selected Roles
                    </button>
                    <button onclick="bulkResetPermissions()" class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Reset Permissions to Default
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Open permission templates modal
function openPermissionTemplates() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    modal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-3xl shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Permission Templates</h3>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer" onclick="applyTemplate('basic')">
                        <h4 class="font-semibold text-gray-900">Basic User</h4>
                        <p class="text-sm text-gray-600 mt-1">Read-only permissions for basic users</p>
                        <div class="mt-2 text-xs text-gray-500">12 permissions</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer" onclick="applyTemplate('moderator')">
                        <h4 class="font-semibold text-gray-900">Moderator</h4>
                        <p class="text-sm text-gray-600 mt-1">Read + write permissions for content management</p>
                        <div class="mt-2 text-xs text-gray-500">28 permissions</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer" onclick="applyTemplate('manager')">
                        <h4 class="font-semibold text-gray-900">Manager</h4>
                        <p class="text-sm text-gray-600 mt-1">Comprehensive permissions for department managers</p>
                        <div class="mt-2 text-xs text-gray-500">45 permissions</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer" onclick="applyTemplate('admin')">
                        <h4 class="font-semibold text-gray-900">Administrator</h4>
                        <p class="text-sm text-gray-600 mt-1">Full administrative permissions except system settings</p>
                        <div class="mt-2 text-xs text-gray-500">72 permissions</div>
                    </div>
                </div>
                <div class="mt-6">
                    <button onclick="saveAsTemplate()" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Save Current Role as Template
                    </button>
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
}

// Bulk action functions
function bulkActivate() {
    const selected = getSelectedRoles();
    if (selected.length === 0) {
        alert('Please select roles to activate');
        return;
    }
    if (confirm(`Activate ${selected.length} role(s)?`)) {
        // Implementation would go here
        alert('Bulk activation will be implemented in the next version');
    }
}

function bulkDeactivate() {
    const selected = getSelectedRoles();
    if (selected.length === 0) {
        alert('Please select roles to deactivate');
        return;
    }
    if (confirm(`Deactivate ${selected.length} role(s)?`)) {
        // Implementation would go here
        alert('Bulk deactivation will be implemented in the next version');
    }
}

function bulkDelete() {
    const selected = getSelectedRoles();
    if (selected.length === 0) {
        alert('Please select roles to delete');
        return;
    }
    if (confirm(`Delete ${selected.length} role(s)? This action cannot be undone!`)) {
        // Implementation would go here
        alert('Bulk deletion will be implemented in the next version');
    }
}

function bulkClone() {
    const selected = getSelectedRoles();
    if (selected.length === 0) {
        alert('Please select roles to clone');
        return;
    }
    if (confirm(`Clone ${selected.length} role(s)?`)) {
        // Implementation would go here
        alert('Bulk cloning will be implemented in the next version');
    }
}

function bulkResetPermissions() {
    const selected = getSelectedRoles();
    if (selected.length === 0) {
        alert('Please select roles to reset');
        return;
    }
    if (confirm(`Reset permissions for ${selected.length} role(s) to default?`)) {
        // Implementation would go here
        alert('Bulk permission reset will be implemented in the next version');
    }
}

function applyTemplate(templateName) {
    alert(`Applying '${templateName}' template will be implemented in the next version`);
}

function saveAsTemplate() {
    alert('Save as template functionality will be implemented in the next version');
}

function getSelectedRoles() {
    const checkboxes = document.querySelectorAll('.role-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// Clone role function
function cloneRole(roleId) {
    if (confirm('Clone this role with all its permissions?')) {
        fetch(`/settings/roles/${roleId}/clone`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error cloning role: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while cloning the role.');
        });
    }
}

// View role permissions summary
function viewPermissionSummary(roleId) {
    window.location.href = `/settings/permissions/${roleId}/show`;
}
</script>
@endpush

