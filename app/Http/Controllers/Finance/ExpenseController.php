<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = FinanceTransaction::where('type', 'expense')
            ->with('creator')
            ->latest()
            ->paginate(20);
        
        // Get all expenses for statistics (not paginated)
        $allExpenses = FinanceTransaction::where('type', 'expense')->get();
        
        return view('finance.expenses.index', compact('expenses', 'allExpenses'));
    }

    public function create()
    {
        return view('finance.expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:matumizi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['type'] = 'expense';
        $validated['created_by'] = auth()->id();

        FinanceTransaction::create($validated);

        return redirect()->route('finance.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    public function show($id)
    {
        $expense = FinanceTransaction::where('type', 'expense')->findOrFail($id);
        return view('finance.expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = FinanceTransaction::where('type', 'expense')->findOrFail($id);
        return view('finance.expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $expense = FinanceTransaction::where('type', 'expense')->findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|in:matumizi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('finance.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = FinanceTransaction::where('type', 'expense')->findOrFail($id);
        $expense->delete();

        return redirect()->route('finance.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
