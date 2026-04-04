@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Profile</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage your personal information and preferences</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="refreshStats()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 014.582 15.356m0 0a8.003 8.003 0 01-4.417 15.357m0 0H4v16a2 2 0 002 2z"></path>
                </svg>
                <span>Refresh Stats</span>
            </button>
            <a href="{{ route('settings.account') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                Account Settings
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center space-x-4 mb-6">
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" 
                             class="h-20 w-20 rounded-full object-cover border-4 border-gray-200">
                        <button onclick="showAvatarModal()" class="absolute bottom-0 right-0 bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586 4.586a2 2 0 014.415 0-4.171-4.586-4.171-4.586h-8.171a2 2 0 01-1.414 1.414V6a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 016 0zm12 0a4 4 0 11-8 0 4 4 0 016 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    @if($user->role)
                        <p class="text-sm text-purple-600 font-medium">{{ $user->role->display_name ?? $user->role->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Profile Completion -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium text-gray-700">Profile Completion</h3>
                    <span class="text-sm text-gray-500">Last updated: {{ $user->updated_at->diffForHumans() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-purple-600 h-3 rounded-full" style="width: 75%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-600 mt-1">
                    <span>75% Complete</span>
                    <a href="{{ route('settings.account') }}" class="text-purple-600 hover:underline">Complete Profile</a>
                </div>
            </div>

            <!-- Basic Info -->
            <div class="space-y-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Basic Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <p class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <p class="text-gray-900">{{ $user->location ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <p class="text-gray-900 truncate">{{ $user->website ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <p class="text-gray-900">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Activity Statistics</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600" id="accountAge">--</div>
                    <div class="text-sm text-blue-800">Account Age</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600" id="lastLogin">--</div>
                    <div class="text-sm text-green-800">Last Login</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-3xl font-bold text-purple-600" id="totalLogins">--</div>
                    <div class="text-sm text-purple-800">Total Logins</div>
                </div>
            </div>
            
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Recent Activity</h4>
                <div class="space-y-2" id="recentActivity">
                    @foreach($user->activityLogs ?? [] as $activity)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $activity->action }}</p>
                            <p class="text-xs text-gray-600">{{ $activity->description }}</p>
                        </div>
                        <div class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div id="avatarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-lg shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Update Profile Picture</h3>
                <button onclick="closeAvatarModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="avatarForm" method="POST" action="{{ route('profile.upload-avatar') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex items-center justify-center">
                    <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                        <img id="avatarPreview" src="{{ $user->avatar ? asset($user->avatar) : '' }}" alt="Preview" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 ml-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Choose Image</label>
                            <input type="file" name="avatar" accept="image/*" onchange="previewAvatar(this)" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Allowed formats: JPEG, PNG, GIF. Maximum size: 2MB
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeAvatarModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Upload Avatar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Load profile stats
function loadProfileStats() {
    fetch('{{ route('profile.stats') }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('accountAge').textContent = data.account_age;
            document.getElementById('lastLogin').textContent = data.last_login;
            document.getElementById('totalLogins').textContent = data.total_logins;
            
            // Update recent activity
            const activityContainer = document.getElementById('recentActivity');
            activityContainer.innerHTML = data.recent_activity.map(activity => `
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-900">${activity.action}</p>
                        <p class="text-xs text-gray-600">${activity.description}</p>
                    </div>
                    <div class="text-xs text-gray-500">${activity.created_at}</div>
                </div>
            `).join('');
        })
        .catch(error => console.error('Error loading stats:', error));
}

// Avatar modal functions
function showAvatarModal() {
    document.getElementById('avatarModal').style.display = 'block';
}

function closeAvatarModal() {
    document.getElementById('avatarModal').style.display = 'none';
}

function previewAvatar(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

function refreshStats() {
    loadProfileStats();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', loadProfileStats);
</script>
@endpush
