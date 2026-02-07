<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use App\Models\SmsBatch;
use Illuminate\Http\Request;

class SmsBatchController extends Controller
{
    public function index()
    {
        $batches = SmsBatch::with('campaign')
            ->latest()
            ->paginate(20);
        
        return view('sms.batches.index', compact('batches'));
    }
}
