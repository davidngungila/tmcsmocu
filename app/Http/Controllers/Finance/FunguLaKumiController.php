<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\FinancialYear;
use App\Models\Parishioner;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FunguLaKumiController extends Controller
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
            ->where('category', 'fungu_la_kumi');
        
        if ($activeYear) {
            $query->where('financial_year_id', $activeYear->id);
        }
        
        $funguLaKumi = $query->with(['creator', 'parishioner'])
            ->latest()
            ->paginate(20);
        
        return view('finance.fungu-la-kumi.index', compact('funguLaKumi', 'activeYear'));
    }

    public function create()
    {
        $parishioners = Parishioner::where('is_active', true)
            ->orderBy('first_name')
            ->get();
        
        return view('finance.fungu-la-kumi.create', compact('parishioners'));
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
        $validated['category'] = 'fungu_la_kumi';
        $validated['title'] = 'Tenth - ' . $parishioner->full_name;
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
            $message = "Thank you {$parishioner->first_name} for your Tenth contribution of TSh {$amount}. God bless you.";
            
            try {
                $this->notificationService->sendSMS($phone, $message);
                Log::info('Fungu la Kumi SMS sent successfully', [
                    'parishioner_id' => $parishioner->id,
                    'phone' => $phone,
                    'amount' => $validated['amount']
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send Fungu la Kumi SMS', [
                    'parishioner_id' => $parishioner->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()->route('finance.fungu-la-kumi.index')
            ->with('success', 'Tenth recorded successfully and thank you message sent to contributor.');
    }

    public function show($id)
    {
        $funguLaKumi = FinanceTransaction::where('type', 'income')
            ->where('category', 'fungu_la_kumi')
            ->with(['creator', 'parishioner'])
            ->findOrFail($id);
        
        return view('finance.fungu-la-kumi.show', compact('funguLaKumi'));
    }
}
