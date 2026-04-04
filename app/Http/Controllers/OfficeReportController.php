<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeReportController extends Controller
{
    public function index()
    {
        return view('reports.office');
    }
    
    public function pdf()
    {
        // Generate PDF report
        return response()->download('office-report.pdf');
    }
}
