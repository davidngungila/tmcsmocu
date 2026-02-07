@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Roles & Permissions</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage user roles and their permissions</p>
        </div>
    </div>
    
    <!-- Roles List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($roles as $role)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $role->name }}</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $role->description ?? 'No description' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-500">Users</p>
                    <p class="text-xl font-bold text-purple-600">{{ $role->users_count ?? 0 }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('settings.permissions.update', $role->id) }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                @foreach($availablePermissions as $category => $permissions)
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase">{{ $category }}</h3>
                    <div class="space-y-2">
                        @foreach($permissions as $key => $label)
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                {{ in_array($key, $role->permissions ?? []) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
                
                <div class="border-t border-gray-200 pt-4">
                    <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                        Update Permissions
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
    
    @if($roles->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        <p class="text-gray-500 text-base">No roles found. Create roles in the database.</p>
    </div>
    @endif
</div>
@endsection

