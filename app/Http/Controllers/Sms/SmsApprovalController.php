<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsCampaign;
use Illuminate\Http\Request;

class SmsApprovalController extends Controller
{
    public function index()
    {
        $pending = SmsCampaign::where('status', 'pending_approval')
            ->with('creator')
            ->latest()
            ->get();
        
        $approved = SmsCampaign::where('status', 'approved')
            ->with(['creator', 'approver'])
            ->latest()
            ->limit(10)
            ->get();
        
        $rejected = SmsCampaign::where('status', 'rejected')
            ->with(['creator', 'approver'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('sms.approval.index', compact('pending', 'approved', 'rejected'));
    }

    public function approve($id)
    {
        $campaign = SmsCampaign::findOrFail($id);
        
        $campaign->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Queue SMS sending job (or send immediately)
        // For now, we'll mark recipients as ready to send
        $campaign->recipients()->update(['status' => 'pending']);

        return redirect()->route('sms.approval.index')
            ->with('success', 'SMS campaign approved successfully. SMS will be sent shortly.');
    }

    public function reject(Request $request, $id)
    {
        $campaign = SmsCampaign::findOrFail($id);
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $campaign->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('sms.approval.index')
            ->with('success', 'SMS campaign rejected.');
    }
}
