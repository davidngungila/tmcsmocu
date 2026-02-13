<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
use App\Models\Parishioner;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShukraniController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $activeYear = FinancialYear::getActive();
        $query = FinanceTransaction::where('type', 'income')
            ->where('category', 'shukrani');
        
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $shukrani = $query->with(['creator', 'parishioner'])
            ->latest()
            ->paginate(20);
        
        return view('finance.shukrani.index', compact('shukrani', 'activeYear'));
    }

    public function create()
    {
        $parishioners = Parishioner::where('is_active', true)
            ->orderBy('first_name')
            ->get();
        
        return view('finance.shukrani.create', compact('parishioners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parishioner_id' => 'required|exists:parishioners,id',
            'amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $parishioner = Parishioner::findOrFail($validated['parishioner_id']);
        
        $validated['type'] = 'income';
        $validated['category'] = 'shukrani';
        $validated['title'] = 'Thanksgiving - ' . $parishioner->full_name;
        $validated['created_by'] = auth()->id();
        
        $activeYear = FinancialYear::getActive();
        if ($activeYear) {
            $validated['financial_year_id'] = $activeYear->id;
        }

        $transaction = FinanceTransaction::create($validated);

        // Send SMS to parishioner
        if ($parishioner->phone || $parishioner->contact_number) {
            $phone = $parishioner->phone ?: $parishioner->contact_number;
            $amount = number_format($validated['amount'], 0);
            $message = "Thank you {$parishioner->first_name} for your Thanksgiving contribution of TSh {$amount}. God bless you.";
            
            try {
                $this->notificationService->sendSMS($phone, $message);
                Log::info('Shukrani SMS sent successfully', [
                    'parishioner_id' => $parishioner->id,
                    'phone' => $phone,
                    'amount' => $validated['amount']
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send Shukrani SMS', [
                    'parishioner_id' => $parishioner->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('finance.shukrani.index')
            ->with('success', 'Shukrani imeandikwa kwa mafanikio na ujumbe wa shukrani umetumwa kwa mtoaji.');
    }

    public function show($id)
    {
        $shukrani = FinanceTransaction::where('type', 'income')
            ->where('category', 'shukrani')
            ->with(['creator', 'parishioner'])
            ->findOrFail($id);
        
        return view('finance.shukrani.show', compact('shukrani'));
    }
}
