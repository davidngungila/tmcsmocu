<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $user->load(['role', 'activityLogs' => function($query) {
            return $query->latest()->limit(10);
        }]);
        
        return view('profile.show', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $user->update($validated);

        // Log activity
        $this->logActivity('Profile updated', 'User updated their profile information');

        return back()->with('success', 'Profile updated successfully.');
    }
    
    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $avatar = $request->file('avatar');
        $avatarPath = $avatar->store('avatars', 'public');
        
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $avatarPath]);

        $this->logActivity('Avatar updated', 'User changed their profile picture');

        return response()->json([
            'success' => true,
            'avatar_url' => asset($avatarPath),
            'message' => 'Avatar updated successfully.'
        ]);
    }
    
    public function removeAvatar()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            
            $this->logActivity('Avatar removed', 'User removed their profile picture');
        }

        return back()->with('success', 'Avatar removed successfully.');
    }
    
    public function getStats()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $stats = [
            'profile_completion' => $this->calculateProfileCompletion($user),
            'account_age' => $user->created_at->diffInDays(now()),
            'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never',
            'total_logins' => $user->activityLogs()->count(),
            'recent_activity' => $user->activityLogs()->latest()->take(5)->get(),
        ];

        return response()->json($stats);
    }
    
    private function calculateProfileCompletion($user)
    {
        $fields = [
            'name' => !empty($user->name),
            'email' => !empty($user->email),
            'phone' => !empty($user->phone),
            'bio' => !empty($user->bio),
            'location' => !empty($user->location),
            'avatar' => !empty($user->avatar),
            'date_of_birth' => !empty($user->date_of_birth),
            'gender' => !empty($user->gender),
        ];
        
        $completed = count(array_filter($fields));
        $total = count($fields);
        
        return round(($completed / $total) * 100);
    }
    
    private function logActivity($action, $description)
    {
        $user = Auth::user();
        if ($user) {
            $user->activityLogs()->create([
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
