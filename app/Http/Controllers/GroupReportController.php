<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupReportController extends Controller
{
    public function index()
    {
        return view('reports.group');
    }
    
    public function pdf()
    {
        return response()->download('group-report.pdf');
    }
}
