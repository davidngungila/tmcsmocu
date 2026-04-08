<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Community;
use App\Models\SpiritualGroup;

class CommunityGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's community
     */
    public function myCommunity()
    {
        $user = auth()->user();
        
        // Get user's community (assuming relationship exists)
        $community = $user->community;
        
        if (!$community) {
            return view('community-groups.no-community', compact('user'));
        }

        // Get community members
        $members = User::where('community_id', $community->id)
            ->with('role')
            ->orderBy('name')
            ->paginate(20);

        // Get community activities/events
        $activities = $community->activities()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('community-groups.my-community', compact(
            'community',
            'members',
            'activities'
        ));
    }

    /**
     * Show user's spiritual group
     */
    public function mySpiritualGroup()
    {
        $user = auth()->user();
        
        // Get user's spiritual group (assuming relationship exists)
        $spiritualGroup = $user->spiritualGroup;
        
        if (!$spiritualGroup) {
            return view('community-groups.no-spiritual-group', compact('user'));
        }

        // Get group members
        $members = User::where('spiritual_group_id', $spiritualGroup->id)
            ->with('role')
            ->orderBy('name')
            ->paginate(20);

        // Get group activities/events
        $activities = $spiritualGroup->activities()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('community-groups.my-spiritual-group', compact(
            'spiritualGroup',
            'members',
            'activities'
        ));
    }

    /**
     * Show all communities (for authorized users)
     */
    public function allCommunities()
    {
        if (!auth()->user()->canViewAllCommunities()) {
            abort(403, 'You do not have permission to view all communities.');
        }

        $communities = Community::with(['leader', 'members' => function($query) {
            $query->limit(5);
        }])
        ->withCount('members')
        ->orderBy('name')
        ->paginate(15);

        return view('community-groups.all-communities', compact('communities'));
    }

    /**
     * Show all spiritual groups (for authorized users)
     */
    public function allSpiritualGroups()
    {
        if (!auth()->user()->canViewAllSpiritualGroups()) {
            abort(403, 'You do not have permission to view all spiritual groups.');
        }

        $spiritualGroups = SpiritualGroup::with(['leader', 'members' => function($query) {
            $query->limit(5);
        }])
        ->withCount('members')
        ->orderBy('name')
        ->paginate(15);

        return view('community-groups.all-spiritual-groups', compact('spiritualGroups'));
    }

    /**
     * Join a community
     */
    public function joinCommunity(Request $request, $id)
    {
        $community = Community::findOrFail($id);
        $user = auth()->user();

        if (!$user->canJoinCommunity($community)) {
            return back()->with('error', 'You cannot join this community.');
        }

        // Logic to join community
        $user->community_id = $community->id;
        $user->save();

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($community)
            ->log('Joined community');

        return back()->with('success', 'You have successfully joined the community.');
    }

    /**
     * Join a spiritual group
     */
    public function joinSpiritualGroup(Request $request, $id)
    {
        $spiritualGroup = SpiritualGroup::findOrFail($id);
        $user = auth()->user();

        if (!$user->canJoinSpiritualGroup($spiritualGroup)) {
            return back()->with('error', 'You cannot join this spiritual group.');
        }

        // Logic to join spiritual group
        $user->spiritual_group_id = $spiritualGroup->id;
        $user->save();

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($spiritualGroup)
            ->log('Joined spiritual group');

        return back()->with('success', 'You have successfully joined the spiritual group.');
    }

    /**
     * Leave a community
     */
    public function leaveCommunity()
    {
        $user = auth()->user();
        $community = $user->community;

        if (!$community) {
            return back()->with('error', 'You are not currently in a community.');
        }

        $user->community_id = null;
        $user->save();

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($community)
            ->log('Left community');

        return back()->with('success', 'You have successfully left the community.');
    }

    /**
     * Leave a spiritual group
     */
    public function leaveSpiritualGroup()
    {
        $user = auth()->user();
        $spiritualGroup = $user->spiritualGroup;

        if (!$spiritualGroup) {
            return back()->with('error', 'You are not currently in a spiritual group.');
        }

        $user->spiritual_group_id = null;
        $user->save();

        // Log activity
        activity()
            ->causedBy($user)
            ->performedOn($spiritualGroup)
            ->log('Left spiritual group');

        return back()->with('success', 'You have successfully left the spiritual group.');
    }
}
