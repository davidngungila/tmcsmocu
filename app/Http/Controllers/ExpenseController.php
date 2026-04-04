<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses.
     */
    public function index(): View
    {
        $expenses = Expense::with(['financialYear', 'approvedBy', 'paidBy'])
            ->when(request('category'), fn($query, $category) => $query->byCategory($category))
            ->when(request('type'), fn($query, $type) => $query->byType($type))
            ->when(request('status'), fn($query, $status) => $query->byStatus($status))
            ->when(request('date_from'), fn($query, $date) => $query->where('expense_date', '>=', $date))
            ->when(request('date_to'), fn($query, $date) => $query->where('expense_date', '<=', $date))
            ->orderBy('expense_date', 'desc')
            ->paginate(15);

        // Calculate statistics
        $totalExpenses = Expense::count();
        $totalAmount = Expense::sum('amount');
        $monthlyTotal = Expense::whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->sum('amount');
        $averageAmount = $totalExpenses > 0 ? $totalAmount / $totalExpenses : 0;

        return view('expenses.index', compact(
            'expenses',
            'totalExpenses',
            'totalAmount',
            'monthlyTotal',
            'averageAmount'
        ));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create(): View
    {
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        
        return view('expenses.create', compact('financialYears'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'expense_category' => 'required|in:' . implode(',', array_keys(Expense::CATEGORIES)),
            'expense_type' => 'required|in:' . implode(',', array_keys(Expense::TYPES)),
            'description' => 'required|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:' . implode(',', array_keys(Expense::PAYMENT_METHODS)),
            'vendor' => 'nullable|string|max:255',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,paid,cancelled',
        ]);

        $validated['approved_by'] = auth()->id();

        // Handle receipt attachment
        if ($request->hasFile('receipt_attachment')) {
            $file = $request->file('receipt_attachment');
            $path = $file->store('receipts', 'public');
            $validated['receipt_attachment'] = $path;
        }

        Expense::create($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense recorded successfully!');
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense): View
    {
        $expense->load(['financialYear', 'approvedBy', 'paidBy']);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense): View
    {
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        
        return view('expenses.edit', compact('expense', 'financialYears'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'expense_category' => 'required|in:' . implode(',', array_keys(Expense::CATEGORIES)),
            'expense_type' => 'required|in:' . implode(',', array_keys(Expense::TYPES)),
            'description' => 'required|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'payment_method' => 'required|in:' . implode(',', array_keys(Expense::PAYMENT_METHODS)),
            'vendor' => 'nullable|string|max:255',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,paid,cancelled',
        ]);

        // Handle receipt attachment update
        if ($request->hasFile('receipt_attachment')) {
            $file = $request->file('receipt_attachment');
            $path = $file->store('receipts', 'public');
            $validated['receipt_attachment'] = $path;
            
            // Delete old attachment if exists
            if ($expense->receipt_attachment && Storage::disk('public')->exists($expense->receipt_attachment)) {
                Storage::disk('public')->delete($expense->receipt_attachment);
            }
        }

        $expense->update($validated);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense updated successfully!');
    }

    /**
     * Approve the specified expense.
     */
    public function approve(Expense $expense): RedirectResponse
    {
        $expense->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense approved successfully!');
    }

    /**
     * Mark the specified expense as paid.
     */
    public function markAsPaid(Expense $expense): RedirectResponse
    {
        $expense->update([
            'status' => 'paid',
            'paid_by' => auth()->id(),
            'paid_at' => now(),
        ]);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense marked as paid successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        // Delete receipt attachment if exists
        if ($expense->receipt_attachment && Storage::disk('public')->exists($expense->receipt_attachment)) {
            Storage::disk('public')->delete($expense->receipt_attachment);
        }

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }

    /**
     * Show the import form.
     */
    public function import(): View
    {
        return view('expenses.import');
    }

    /**
     * Handle bulk import of expenses.
     */
    public function storeImport(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $importedCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($request->file('files') as $file) {
            try {
                $content = file_get_contents($file->getPathname());
                $lines = explode("\n", $content);
                
                foreach ($lines as $lineNumber => $line) {
                    if ($lineNumber === 0 || empty(trim($line))) continue;
                    
                    $data = str_getcsv($line);
                    
                    if (count($data) < 7) {
                        $errors[] = "File " . $file->getClientOriginalName() . ": Invalid CSV format at line " . ($lineNumber + 1);
                        $errorCount++;
                        continue;
                    }

                    Expense::create([
                        'financial_year_id' => $this->findFinancialYearByName($data[0]),
                        'expense_category' => $data[1],
                        'expense_type' => $data[2],
                        'description' => $data[3],
                        'amount' => floatval($data[4]),
                        'expense_date' => $data[5] ?? now()->format('Y-m-d'),
                        'payment_method' => $data[6],
                        'vendor' => $data[7] ?? null,
                        'invoice_number' => $data[8] ?? null,
                        'notes' => $data[9] ?? null,
                        'status' => 'pending',
                        'approved_by' => auth()->id(),
                    ]);
                    
                    $importedCount++;
                }
            } catch (\Exception $e) {
                $errors[] = "File " . $file->getClientOriginalName() . ": " . $e->getMessage();
                $errorCount++;
            }
        }

        $message = "Successfully imported {$importedCount} expenses.";
        if ($errorCount > 0) {
            $message .= " {$errorCount} files had errors.";
        }

        return redirect()
            ->route('expenses.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Find financial year by name or create new one.
     */
    private function findFinancialYearByName(string $name): ?int
    {
        $year = FinancialYear::where('name', 'like', "%{$name}%")->first();
        return $year ? $year->id : null;
    }
}
