<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommunityReportController extends Controller
{
    public function index()
    {
        return view('reports.community');
    }
    
    public function pdf()
    {
        return response()->download('community-report.pdf');
    }
}
