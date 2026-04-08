@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Profile</h1>
                <p class="text-gray-600 mt-1">Manage your personal information and preferences</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="refreshStats()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 014.582 15.356m0 0a8.003 8.003 0 01-4.417 15.357m0 0H4v16a2 2 0 002 2z"></path>
                    </svg>
                    <span>Refresh</span>
                </button>
                <a href="{{ route('settings.account') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Profile Content (2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card with Avatar -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <div class="relative flex-shrink-0">
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" 
                                 class="h-24 w-24 rounded-full object-cover border-4 border-gray-200">
                            <button onclick="showAvatarModal()" class="absolute bottom-0 right-0 bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700 transition-colors shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        @else
                            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-200">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <button onclick="showAvatarModal()" class="absolute bottom-0 right-0 bg-purple-600 text-white p-2 rounded-full hover:bg-purple-700 transition-colors shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        @if($user->role)
                            <p class="text-sm text-purple-600 font-medium mt-1">{{ $user->role->display_name ?? $user->role->name }}</p>
                        @endif
                        <div class="mt-3 flex flex-wrap gap-2">
                            @if($user->phone)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    {{ $user->phone }}
                                </span>
                            @endif
                            @if($user->location)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $user->location }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Completion -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-700">Profile Completion</h3>
                        <span class="text-sm text-gray-500">Updated {{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: 75%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-600 mt-2">
                        <span>75% Complete</span>
                        <a href="{{ route('settings.account') }}" class="text-purple-600 hover:underline font-medium">Complete Profile</a>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <p class="text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <p class="text-gray-900">{{ $user->location ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <p class="text-gray-900">{{ $user->date_of_birth ? $user->date_of_birth->format('F d, Y') : 'Not provided' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                            <p class="text-gray-900 truncate">{{ $user->website ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <p class="text-gray-900">{{ $user->gender ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <p class="text-gray-900">{{ $user->bio ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-3" id="recentActivity">
                    @foreach($user->activityLogs ?? [] as $activity)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9.5H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $activity->action }}</p>
                            <p class="text-xs text-gray-600">{{ $activity->description }}</p>
                        </div>
                        <div class="flex-shrink-0 text-xs text-gray-500">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                    @if(!($user->activityLogs ?? []))
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>No recent activity</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (1 column) -->
        <div class="space-y-6">
            <!-- Activity Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                <div class="space-y-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600" id="accountAge">--</div>
                        <div class="text-sm text-blue-800">Account Age</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600" id="lastLogin">--</div>
                        <div class="text-sm text-green-800">Last Login</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600" id="totalLogins">--</div>
                        <div class="text-sm text-purple-800">Total Logins</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('settings.account') }}" class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        Edit Profile
                    </a>
                    <a href="{{ route('settings.security') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Security Settings
                    </a>
                    <a href="{{ route('certificates.my') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        My Certificates
                    </a>
                    <a href="{{ route('member-services.contributions') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        My Contributions
                    </a>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Settings</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Email Notifications</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->email_notifications ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">SMS Notifications</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->sms_notifications ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Profile Visibility</span>
                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($user->profile_visibility ?? 'public') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Two-Factor Auth</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->google2fa_enabled ? 'Enabled' : 'Disabled' }}</span>
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
