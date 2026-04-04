<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuditController extends Controller
{
    public function index()
    {
        return view('finance.audit.index');
    }
    
    public function trail()
    {
        return view('finance.audit.trail');
    }
}
