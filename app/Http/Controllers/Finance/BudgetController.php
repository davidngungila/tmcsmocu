<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
    public function index()
    {
        return view('finance.budget.index');
    }

    public function create()
    {
        return view('finance.budget.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('finance.budget.index')->with('success', 'Budget created successfully!');
    }

    public function edit($id)
    {
        return view('finance.budget.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('finance.budget.index')->with('success', 'Budget updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('finance.budget.index')->with('success', 'Budget deleted successfully!');
    }
}
