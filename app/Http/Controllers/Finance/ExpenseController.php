<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $activeYear = FinancialYear::getActive();
        $query = FinanceTransaction::where('type', 'expense');
        
        // Filter by active financial year if exists
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $expenses = $query->with('creator')
            ->latest()
            ->paginate(20);
        
        // Get all expenses for statistics (not paginated)
        $allExpenses = $query->get();
        
        return view('finance.expenses.index', compact('expenses', 'allExpenses', 'activeYear'));
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
        
        // Assign to active financial year if exists
        $activeYear = FinancialYear::getActive();
        if ($activeYear) {
            $validated['financial_year_id'] = $activeYear->id;
        }

        FinanceTransaction::create($validated);

        return redirect()->route('finance.expenses.index')
            ->with('success', 'Matumizi yameandikwa kwa mafanikio.');
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
            ->with('success', 'Matumizi yameboreshwa kwa mafanikio.');
    }

    public function destroy($id)
    {
        $expense = FinanceTransaction::where('type', 'expense')->findOrFail($id);
        $expense->delete();

        return redirect()->route('finance.expenses.index')
            ->with('success', 'Matumizi yamefutwa kwa mafanikio.');
    }
}
