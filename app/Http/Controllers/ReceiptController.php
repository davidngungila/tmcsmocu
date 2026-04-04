<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Contribution;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReceiptController extends Controller
{
    /**
     * Display a listing of receipts.
     */
    public function index(): View
    {
        $receipts = Receipt::with(['parishioner', 'contribution', 'issuedBy'])
            ->when(request('type'), fn($query, $type) => $query->byType($type))
            ->when(request('payment_status'), fn($query, $status) => $query->byPaymentStatus($status))
            ->when(request('date_from'), fn($query, $date) => $query->where('receipt_date', '>=', $date))
            ->when(request('date_to'), fn($query, $date) => $query->where('receipt_date', '<=', $date))
            ->orderBy('receipt_date', 'desc')
            ->paginate(15);

        // Calculate statistics
        $totalReceipts = Receipt::count();
        $totalValue = Receipt::sum('amount');
        $paidReceipts = Receipt::where('payment_status', 'paid')->count();
        $pendingReceipts = Receipt::where('payment_status', 'pending')->count();

        return view('receipts.index', compact(
            'receipts',
            'totalReceipts',
            'totalValue',
            'paidReceipts',
            'pendingReceipts'
        ));
    }

    /**
     * Show the form for creating a new receipt.
     */
    public function create(): View
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'member_type']);
        
        // Get contributions without receipts (simplified query)
        try {
            $contributions = Contribution::leftJoin('receipts', 'contributions.id', '=', 'receipts.contribution_id')
                ->whereNull('receipts.id')
                ->get(['contributions.id', 'contributions.amount', 'contributions.contribution_date']);
        } catch (\Exception $e) {
            $contributions = collect(); // Empty collection if query fails
        }
        
        return view('receipts.create', compact('parishioners', 'contributions'));
    }

    /**
     * Store a newly created receipt in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'contribution_id' => 'nullable|exists:contributions,id',
            'parishioner_id' => 'required|exists:parishioners,id',
            'receipt_number' => 'required|string|max:50|unique:receipts,receipt_number',
            'amount' => 'required|numeric|min:0',
            'receipt_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|in:' . implode(',', array_keys(Receipt::PAYMENT_STATUSES)),
            'transaction_reference' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:' . implode(',', array_keys(Receipt::TYPES)),
        ]);

        $validated['issued_by'] = auth()->id();

        Receipt::create($validated);

        return redirect()
            ->route('receipts.index')
            ->with('success', 'Receipt issued successfully!');
    }

    /**
     * Display the specified receipt.
     */
    public function show(Receipt $receipt): View
    {
        $receipt->load(['parishioner', 'contribution', 'issuedBy']);
        return view('receipts.show', compact('receipt'));
    }

    /**
     * Show the form for editing the specified receipt.
     */
    public function edit(Receipt $receipt): View
    {
        $parishioners = Parishioner::orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('middle_name', 'asc')
            ->get(['id', 'first_name', 'last_name', 'middle_name', 'member_type']);
        
        // Get contributions without receipts (simplified query)
        try {
            $contributions = Contribution::leftJoin('receipts', 'contributions.id', '=', 'receipts.contribution_id')
                ->whereNull('receipts.id')
                ->get(['contributions.id', 'contributions.amount', 'contributions.contribution_date']);
        } catch (\Exception $e) {
            $contributions = collect(); // Empty collection if query fails
        }
        
        return view('receipts.edit', compact('receipt', 'parishioners', 'contributions'));
    }

    /**
     * Update the specified receipt in storage.
     */
    public function update(Request $request, Receipt $receipt): RedirectResponse
    {
        $validated = $request->validate([
            'contribution_id' => 'nullable|exists:contributions,id',
            'parishioner_id' => 'required|exists:parishioners,id',
            'receipt_number' => 'required|string|max:50|unique:receipts,receipt_number,' . $receipt->id,
            'amount' => 'required|numeric|min:0',
            'receipt_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|in:' . implode(',', array_keys(Receipt::PAYMENT_STATUSES)),
            'transaction_reference' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:' . implode(',', array_keys(Receipt::TYPES)),
        ]);

        $receipt->update($validated);

        return redirect()
            ->route('receipts.index')
            ->with('success', 'Receipt updated successfully!');
    }

    /**
     * Remove the specified receipt from storage.
     */
    public function destroy(Receipt $receipt): RedirectResponse
    {
        $receipt->delete();

        return redirect()
            ->route('receipts.index')
            ->with('success', 'Receipt deleted successfully!');
    }

    /**
     * Generate PDF for specified receipt.
     */
    public function pdf(Receipt $receipt)
    {
        // PDF functionality temporarily disabled
        return redirect()->back()->with('info', 'PDF generation temporarily disabled');
    }
}
