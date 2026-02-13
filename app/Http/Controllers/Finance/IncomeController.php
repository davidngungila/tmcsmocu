<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        $activeYear = FinancialYear::getActive();
        $query = FinanceTransaction::where('type', 'income');
        
        // Filter by active financial year if exists
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $incomes = $query->with('creator')
            ->latest()
            ->paginate(20);
        
        // Get all incomes for statistics (not paginated)
        $allIncomes = $query->get();
        
        return view('finance.income.index', compact('incomes', 'allIncomes', 'activeYear'));
    }

    public function create()
    {
        return view('finance.income.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:zaka,sadaka,fungu_la_kumi,michango_mingine',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['type'] = 'income';
        $validated['created_by'] = auth()->id();
        
        // Assign to active financial year if exists
        $activeYear = FinancialYear::getActive();
        if ($activeYear) {
            $validated['financial_year_id'] = $activeYear->id;
        }

        FinanceTransaction::create($validated);

        return redirect()->route('finance.income.index')
            ->with('success', 'Mapato yameandikwa kwa mafanikio.');
    }

    public function show($id)
    {
        $income = FinanceTransaction::where('type', 'income')->findOrFail($id);
        return view('finance.income.show', compact('income'));
    }

    public function edit($id)
    {
        $income = FinanceTransaction::where('type', 'income')->findOrFail($id);
        return view('finance.income.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        $income = FinanceTransaction::where('type', 'income')->findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|in:zaka,sadaka,fungu_la_kumi,michango_mingine',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $income->update($validated);

        return redirect()->route('finance.income.index')
            ->with('success', 'Mapato yameboreshwa kwa mafanikio.');
    }

    public function destroy($id)
    {
        $income = FinanceTransaction::where('type', 'income')->findOrFail($id);
        $income->delete();

        return redirect()->route('finance.income.index')
            ->with('success', 'Mapato yamefutwa kwa mafanikio.');
    }

    public function print($id)
    {
        $income = FinanceTransaction::where('type', 'income')->with('creator')->findOrFail($id);
        return view('finance.income.print', compact('income'));
    }

    public function pdf($id)
    {
        $income = FinanceTransaction::where('type', 'income')->with('creator')->findOrFail($id);
        
        try {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('finance.income.receipt', compact('income'))
                ->setPaper([0, 0, 226.77, 841.89], 'portrait') // 80mm width (226.77 points) for receipt printers
                ->setOption('enable-local-file-access', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);
            
            return $pdf->stream('receipt-' . $income->id . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}

