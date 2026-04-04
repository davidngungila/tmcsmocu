<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Parishioner;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContributionController extends Controller
{
    /**
     * Display a listing of contributions.
     */
    public function index(): View
    {
        // Get contributions with error handling
        try {
            $contributions = Contribution::with(['parishioner', 'financialYear', 'recordedBy'])
                ->when(request('type'), fn($query, $type) => $query->byType($type))
                ->when(request('status'), fn($query, $status) => $query->byStatus($status))
                ->when(request('payment_method'), fn($query, $method) => $query->where('payment_method', $method))
                ->when(request('date_from'), fn($query, $date) => $query->where('contribution_date', '>=', $date))
                ->when(request('date_to'), fn($query, $date) => $query->where('contribution_date', '<=', $date))
                ->orderBy('contribution_date', 'desc')
                ->paginate(15);
        } catch (\Exception $e) {
            $contributions = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
        }

        // Calculate statistics (with error handling)
        try {
            $totalContributions = Contribution::count();
            $totalAmount = Contribution::sum('amount');
            $monthlyTotal = Contribution::whereMonth('contribution_date', now()->month)
                ->whereYear('contribution_date', now()->year)
                ->sum('amount');
            $averageAmount = $totalContributions > 0 ? $totalAmount / $totalContributions : 0;
        } catch (\Exception $e) {
            $totalContributions = 0;
            $totalAmount = 0;
            $monthlyTotal = 0;
            $averageAmount = 0;
        }

        return view('contributions.index', compact(
            'contributions',
            'totalContributions',
            'totalAmount',
            'monthlyTotal',
            'averageAmount'
        ));
    }

    /**
     * Show the form for creating a new contribution.
     */
    public function create(): View
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'member_type']);
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        
        return view('contributions.create', compact('parishioners', 'financialYears'));
    }

    /**
     * Store a newly created contribution in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'contribution_type' => 'required|in:' . implode(',', array_keys(Contribution::TYPES)),
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:' . implode(',', array_keys(Contribution::PAYMENT_METHODS)),
            'transaction_reference' => 'nullable|string|max:255',
            'contribution_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['recorded_by'] = auth()->id();
        $validated['receipt_number'] = 'RCPT-' . date('YmdHis') . '-' . rand(1000, 9999);
        $validated['status'] = 'confirmed';

        Contribution::create($validated);

        return redirect()
            ->route('contributions.index')
            ->with('success', 'Contribution recorded successfully!');
    }

    /**
     * Display the specified contribution.
     */
    public function show(Contribution $contribution): View
    {
        $contribution->load(['parishioner', 'financialYear', 'recordedBy', 'receipts']);
        return view('contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified contribution.
     */
    public function edit(Contribution $contribution): View
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'member_type']);
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        
        return view('contributions.edit', compact('contribution', 'parishioners', 'financialYears'));
    }

    /**
     * Update the specified contribution in storage.
     */
    public function update(Request $request, Contribution $contribution): RedirectResponse
    {
        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'contribution_type' => 'required|in:' . implode(',', array_keys(Contribution::TYPES)),
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:' . implode(',', array_keys(Contribution::PAYMENT_METHODS)),
            'transaction_reference' => 'nullable|string|max:255',
            'contribution_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $contribution->update($validated);

        return redirect()
            ->route('contributions.index')
            ->with('success', 'Contribution updated successfully!');
    }

    /**
     * Remove the specified contribution from storage.
     */
    public function destroy(Contribution $contribution): RedirectResponse
    {
        $contribution->delete();

        return redirect()
            ->route('contributions.index')
            ->with('success', 'Contribution deleted successfully!');
    }

    /**
     * Show the import form.
     */
    public function import(): View
    {
        return view('contributions.import');
    }

    /**
     * Handle bulk import of contributions.
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
                    
                    if (count($data) < 6) {
                        $errors[] = "File " . $file->getClientOriginalName() . ": Invalid CSV format at line " . ($lineNumber + 1);
                        $errorCount++;
                        continue;
                    }

                    Contribution::create([
                        'parishioner_id' => $this->findParishionerByName($data[0]),
                        'financial_year_id' => $this->findFinancialYearByName($data[1]),
                        'contribution_type' => $data[2],
                        'amount' => floatval($data[3]),
                        'payment_method' => $data[4],
                        'transaction_reference' => $data[5] ?? null,
                        'contribution_date' => $data[6] ?? now()->format('Y-m-d'),
                        'description' => $data[7] ?? null,
                        'receipt_number' => 'RCPT-' . date('YmdHis') . '-' . rand(1000, 9999),
                        'status' => 'confirmed',
                        'recorded_by' => auth()->id(),
                    ]);
                    
                    $importedCount++;
                }
            } catch (\Exception $e) {
                $errors[] = "File " . $file->getClientOriginalName() . ": " . $e->getMessage();
                $errorCount++;
            }
        }

        $message = "Successfully imported {$importedCount} contributions.";
        if ($errorCount > 0) {
            $message .= " {$errorCount} files had errors.";
        }

        return redirect()
            ->route('contributions.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Find parishioner by name or create new one.
     */
    private function findParishionerByName(string $name): ?int
    {
        $parishioner = Parishioner::where('full_name', 'like', "%{$name}%")->first();
        return $parishioner ? $parishioner->id : null;
    }

    /**
     * Find financial year by name or create new one.
     */
    private function findFinancialYearByName(string $name): ?int
    {
        $year = FinancialYear::where('name', 'like', "%{$name}%")->first();
        return $year ? $year->id : null;
    }
    
    /**
     * Show form to make a contribution.
     */
    public function make()
    {
        return view('contributions.make');
    }
    
    /**
     * Process contribution payment.
     */
    public function process(Request $request)
    {
        // Implementation pending
        return redirect()->route('contributions.make')->with('success', 'Contribution processed successfully!');
    }
    
    /**
     * Show contribution history.
     */
    public function history()
    {
        $user = auth()->user();
        $contributions = FinanceTransaction::where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('contributions.history', compact('contributions'));
    }
}
