<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use App\Models\Parishioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of financial years
     */
    public function index()
    {
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        $activeYear = FinancialYear::getActive();
        
        return view('settings.financial-years.index', compact('financialYears', 'activeYear'));
    }

    /**
     * Show the form for creating a new financial year
     */
    public function create()
    {
        return view('settings.financial-years.create');
    }

    /**
     * Store a newly created financial year
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string',
            'set_as_active' => 'nullable|boolean',
        ]);

        $financialYear = FinancialYear::create([
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => false,
            'is_closed' => false,
        ]);

        if ($request->has('set_as_active') && $request->set_as_active) {
            $financialYear->setActive();
        }

        return redirect()->route('settings.financial-years.index')
            ->with('success', 'Financial year created successfully.');
    }

    /**
     * Set a financial year as active
     */
    public function setActive($id)
    {
        $financialYear = FinancialYear::findOrFail($id);
        
        if ($financialYear->is_closed) {
            return redirect()->route('settings.financial-years.index')
                ->with('error', 'Cannot activate a closed financial year.');
        }

        $financialYear->setActive();

        return redirect()->route('settings.financial-years.index')
            ->with('success', 'Financial year set as active.');
    }

    /**
     * Close a financial year
     */
    public function close($id)
    {
        $financialYear = FinancialYear::findOrFail($id);
        
        if ($financialYear->is_active) {
            return redirect()->route('settings.financial-years.index')
                ->with('error', 'Cannot close the active financial year. Please activate another year first.');
        }

        $financialYear->close();

        return redirect()->route('settings.financial-years.index')
            ->with('success', 'Financial year closed successfully.');
    }

    /**
     * Transition to a new financial year
     * This will mark active parishioners as graduated and new parishioners as new
     */
    public function transition(Request $request, $id)
    {
        $newYear = FinancialYear::findOrFail($id);
        $oldYear = FinancialYear::getActive();

        if (!$oldYear) {
            return redirect()->route('settings.financial-years.index')
                ->with('error', 'No active financial year found.');
        }

        DB::transaction(function () use ($newYear, $oldYear, $request) {
            // Get all active parishioners from the old year
            $activeParishioners = Parishioner::whereHas('financialYears', function ($query) use ($oldYear) {
                $query->where('financial_years.id', $oldYear->id)
                    ->where('parishioner_financial_years.status', 'active');
            })->get();

            // Mark them as graduated in the old year
            foreach ($activeParishioners as $parishioner) {
                $parishioner->financialYears()->updateExistingPivot($oldYear->id, [
                    'status' => 'graduated',
                    'graduated_date' => $oldYear->end_date,
                ]);
            }

            // Get all parishioners who should be active in the new year
            // This includes:
            // 1. New parishioners (not in old year or were new in old year)
            // 2. Active parishioners who continue (based on is_active flag)
            
            $parishionersToAdd = Parishioner::where('is_active', true)
                ->whereDoesntHave('financialYears', function ($query) use ($newYear) {
                    $query->where('financial_years.id', $newYear->id);
                })
                ->get();

            // Add parishioners to new year
            foreach ($parishionersToAdd as $parishioner) {
                $status = 'new'; // New parishioners start as 'new'
                
                // If they were active in old year, they continue as 'active'
                $wasActive = $parishioner->financialYears()
                    ->where('financial_years.id', $oldYear->id)
                    ->where('parishioner_financial_years.status', 'active')
                    ->exists();
                
                if ($wasActive) {
                    $status = 'active';
                }

                $parishioner->financialYears()->attach($newYear->id, [
                    'status' => $status,
                    'joined_date' => $newYear->start_date,
                ]);
            }

            // Set new year as active
            $newYear->setActive();
        });

        return redirect()->route('settings.financial-years.index')
            ->with('success', 'Successfully transitioned to new financial year.');
    }

    /**
     * Show transition form
     */
    public function showTransition($id)
    {
        $newYear = FinancialYear::findOrFail($id);
        $oldYear = FinancialYear::getActive();

        if (!$oldYear) {
            return redirect()->route('settings.financial-years.index')
                ->with('error', 'No active financial year found.');
        }

        $activeParishioners = Parishioner::whereHas('financialYears', function ($query) use ($oldYear) {
            $query->where('financial_years.id', $oldYear->id)
                ->where('parishioner_financial_years.status', 'active');
        })->count();

        $newParishioners = Parishioner::where('is_active', true)
            ->whereDoesntHave('financialYears', function ($query) use ($newYear) {
                $query->where('financial_years.id', $newYear->id);
            })
            ->count();

        return view('settings.financial-years.transition', compact('newYear', 'oldYear', 'activeParishioners', 'newParishioners'));
    }
}
