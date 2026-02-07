<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsCampaign;
use App\Models\SmsBatch;
use App\Models\SmsRecipient;
use Illuminate\Http\Request;

class SmsReportController extends Controller
{
    public function index()
    {
        $totalSent = SmsRecipient::where('status', 'sent')->count();
        $totalFailed = SmsRecipient::where('status', 'failed')->count();
        $totalPending = SmsRecipient::where('status', 'pending')->count();
        
        $campaigns = SmsCampaign::with(['creator', 'approver'])
            ->latest()
            ->paginate(20);
        
        return view('sms.reports.index', compact('totalSent', 'totalFailed', 'totalPending', 'campaigns'));
    }
}
