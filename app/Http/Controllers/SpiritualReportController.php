<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpiritualReportController extends Controller
{
    public function index()
    {
        return view('reports.spiritual');
    }
    
    public function pdf()
    {
        return response()->download('spiritual-report.pdf');
    }
}
