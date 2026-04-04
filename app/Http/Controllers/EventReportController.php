<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventReportController extends Controller
{
    public function index()
    {
        return view('reports.event');
    }
    
    public function show($id)
    {
        return view('reports.event.show', ['id' => $id]);
    }
    
    public function pdf($id)
    {
        return response()->download("event-report-{$id}.pdf");
    }
}
