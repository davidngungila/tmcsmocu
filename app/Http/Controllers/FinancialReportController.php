<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\Expense;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialReportController extends Controller
{
    /**
     * Display a listing of financial reports.
     */
    public function index(Request $request): View
    {
        $financialYears = FinancialYear::orderBy('start_date', 'desc')->get();
        $reportType = $request->get('report_type', 'summary');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $financialYearId = $request->get('financial_year_id');

        // Get base data
        $contributionsQuery = Contribution::with(['parishioner', 'financialYear'])
            ->when($financialYearId, fn($query, $id) => $query->inFinancialYear($id))
            ->when($startDate, fn($query, $date) => $query->where('contribution_date', '>=', $date))
            ->when($endDate, fn($query, $date) => $query->where('contribution_date', '<=', $date));

        $expensesQuery = Expense::with(['financialYear'])
            ->when($financialYearId, fn($query, $id) => $query->inFinancialYear($id))
            ->when($startDate, fn($query, $date) => $query->where('expense_date', '>=', $date))
            ->when($endDate, fn($query, $date) => $query->where('expense_date', '<=', $date));

        // Calculate totals
        $totalIncome = $contributionsQuery->sum('amount');
        $totalExpenses = $expensesQuery->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        $totalTransactions = $contributionsQuery->count() + $expensesQuery->count();

        // Contribution breakdown
        $contributionBreakdown = $contributionsQuery->selectRaw('contribution_type, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('contribution_type')
            ->get()
            ->mapWithKeys(function ($item) {
                $percentage = $totalIncome > 0 ? ($item->total / $totalIncome) * 100 : 0;
                return [
                    'count' => $item->count,
                    'total' => $item->total,
                    'percentage' => round($percentage, 1)
                ];
            });

        // Expense breakdown
        $expenseBreakdown = $expensesQuery->selectRaw('expense_category, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('expense_category')
            ->get()
            ->mapWithKeys(function ($item) {
                $percentage = $totalExpenses > 0 ? ($item->total / $totalExpenses) * 100 : 0;
                return [
                    'count' => $item->count,
                    'total' => $item->total,
                    'percentage' => round($percentage, 1)
                ];
            });

        // Cash flow data
        $cashFlow = $this->generateCashFlowData($contributionsQuery, $expensesQuery, $startDate, $endDate);

        return view('financial-reports.index', compact(
            'financialYears',
            'reportType',
            'startDate',
            'endDate',
            'financialYearId',
            'totalIncome',
            'totalExpenses',
            'netBalance',
            'totalTransactions',
            'contributionBreakdown',
            'expenseBreakdown',
            'cashFlow'
        ));
    }

    /**
     * Generate and export financial reports.
     */
    public function export(Request $request): StreamedResponse
    {
        $format = $request->get('format', 'pdf');
        $reportType = $request->get('report_type', 'summary');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $financialYearId = $request->get('financial_year_id');

        // Get data
        $contributionsQuery = Contribution::with(['parishioner', 'financialYear'])
            ->when($financialYearId, fn($query, $id) => $query->inFinancialYear($id))
            ->when($startDate, fn($query, $date) => $query->where('contribution_date', '>=', $date))
            ->when($endDate, fn($query, $date) => $query->where('contribution_date', '<=', $date));

        $expensesQuery = Expense::with(['financialYear'])
            ->when($financialYearId, fn($query, $id) => $query->inFinancialYear($id))
            ->when($startDate, fn($query, $date) => $query->where('expense_date', '>=', $date))
            ->when($endDate, fn($query, $date) => $query->where('expense_date', '<=', $date));

        $data = match($reportType) {
            'summary' => $this->generateSummaryData($contributionsQuery, $expensesQuery),
            'contributions' => $this->generateContributionsData($contributionsQuery),
            'expenses' => $this->generateExpensesData($expensesQuery),
            'cash_flow' => $this->generateCashFlowData($contributionsQuery, $expensesQuery, $startDate, $endDate),
            'balance_sheet' => $this->generateBalanceSheetData($contributionsQuery, $expensesQuery),
            default => $this->generateSummaryData($contributionsQuery, $expensesQuery),
        };

        return match($format) {
            'pdf' => $this->generatePdfReport($data, $reportType),
            'excel' => $this->generateExcelReport($data, $reportType),
            'csv' => $this->generateCsvReport($data, $reportType),
            default => $this->generatePdfReport($data, $reportType),
        };
    }

    /**
     * Generate cash flow data.
     */
    private function generateCashFlowData($contributionsQuery, $expensesQuery, $startDate, $endDate): array
    {
        $monthlyData = [];
        $period = new \DatePeriod(new \DateTime($startDate), new \DateTime($endDate));

        foreach ($period as $date) {
            $month = $date->format('F Y');
            $monthIncome = $contributionsQuery->whereMonth('contribution_date', $date->format('m'))
                ->whereYear('contribution_date', $date->format('Y'))
                ->sum('amount');
            
            $monthExpenses = $expensesQuery->whereMonth('expense_date', $date->format('m'))
                ->whereYear('expense_date', $date->format('Y'))
                ->sum('amount');

            $monthlyData[$month] = [
                'income' => $monthIncome,
                'expenses' => $monthExpenses,
                'net' => $monthIncome - $monthExpenses,
            ];
        }

        return $monthlyData;
    }

    /**
     * Generate summary report data.
     */
    private function generateSummaryData($contributionsQuery, $expensesQuery): array
    {
        $totalIncome = $contributionsQuery->sum('amount');
        $totalExpenses = $expensesQuery->sum('amount');
        
        return [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_balance' => $totalIncome - $totalExpenses,
            'contributions_count' => $contributionsQuery->count(),
            'expenses_count' => $expensesQuery->count(),
        ];
    }

    /**
     * Generate contributions report data.
     */
    private function generateContributionsData($contributionsQuery): array
    {
        return $contributionsQuery->with(['parishioner', 'financialYear', 'recordedBy'])
            ->orderBy('contribution_date', 'desc')
            ->get()
            ->map(function ($contribution) {
                return [
                    'date' => $contribution->contribution_date->format('Y-m-d'),
                    'parishioner' => $contribution->parishioner->full_name ?? 'N/A',
                    'type' => \App\Models\Contribution::TYPES[$contribution->contribution_type] ?? $contribution->contribution_type,
                    'amount' => $contribution->amount,
                    'payment_method' => $contribution->payment_method,
                    'status' => $contribution->status,
                ];
            })
            ->toArray();
    }

    /**
     * Generate expenses report data.
     */
    private function generateExpensesData($expensesQuery): array
    {
        return $expensesQuery->with(['financialYear', 'approvedBy', 'paidBy'])
            ->orderBy('expense_date', 'desc')
            ->get()
            ->map(function ($expense) {
                return [
                    'date' => $expense->expense_date->format('Y-m-d'),
                    'category' => \App\Models\Expense::CATEGORIES[$expense->expense_category] ?? $expense->expense_category,
                    'type' => \App\Models\Expense::TYPES[$expense->expense_type] ?? $expense->expense_type,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'vendor' => $expense->vendor ?? 'N/A',
                    'payment_method' => $expense->payment_method,
                    'status' => $expense->status,
                ];
            })
            ->toArray();
    }

    /**
     * Generate balance sheet data.
     */
    private function generateBalanceSheetData($contributionsQuery, $expensesQuery): array
    {
        $totalIncome = $contributionsQuery->sum('amount');
        $totalExpenses = $expensesQuery->sum('amount');
        
        return [
            'assets' => [
                'cash_in_bank' => $totalIncome,
                'outstanding_receivables' => 0,
            ],
            'liabilities' => [
                'accounts_payable' => 0,
                'expenses' => $totalExpenses,
            ],
            'equity' => [
                'retained_earnings' => $totalIncome - $totalExpenses,
            ],
        ];
    }

    /**
     * Generate PDF report.
     */
    private function generatePdfReport($data, $reportType): StreamedResponse
    {
        $filename = 'financial_report_' . $reportType . '_' . date('Y-m-d') . '.pdf';
        
        $pdf = \PDF::loadView('financial-reports.pdf', compact('data', 'reportType'))
            ->setPaper('a4')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download($filename);
    }

    /**
     * Generate Excel report.
     */
    private function generateExcelReport($data, $reportType): StreamedResponse
    {
        // Implementation would require a package like maatwebsite/excel
        // For now, return CSV format
        return $this->generateCsvReport($data, $reportType);
    }

    /**
     * Generate CSV report.
     */
    private function generateCsvReport($data, $reportType): StreamedResponse
    {
        $filename = 'financial_report_' . $reportType . '_' . date('Y-m-d') . '.csv';
        
        $headers = match($reportType) {
            'summary' => ['Report Type', 'Total Income', 'Total Expenses', 'Net Balance', 'Contributions Count', 'Expenses Count'],
            'contributions' => ['Date', 'Parishioner', 'Type', 'Amount', 'Payment Method', 'Status'],
            'expenses' => ['Date', 'Category', 'Type', 'Description', 'Amount', 'Vendor', 'Payment Method', 'Status'],
            'cash_flow' => ['Month', 'Income', 'Expenses', 'Net Flow'],
            'balance_sheet' => ['Category', 'Assets', 'Liabilities', 'Equity'],
            default => ['Report Type', 'Total Income', 'Total Expenses', 'Net Balance'],
        };

        $callback = function() use ($data, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Write headers
            fputcsv($file, $headers[$reportType]);
            
            // Write data rows
            switch ($reportType) {
                case 'summary':
                    fputcsv($file, ['Summary', $data['total_income'], $data['total_expenses'], $data['net_balance'], $data['contributions_count'], $data['expenses_count']]);
                    break;
                case 'contributions':
                    foreach ($data as $row) {
                        fputcsv($file, [$row['date'], $row['parishioner'], $row['type'], $row['amount'], $row['payment_method'], $row['status']]);
                    }
                    break;
                case 'expenses':
                    foreach ($data as $row) {
                        fputcsv($file, [$row['date'], $row['category'], $row['type'], $row['description'], $row['amount'], $row['vendor'], $row['payment_method'], $row['status']]);
                    }
                    break;
                case 'cash_flow':
                    foreach ($data as $month => $row) {
                        fputcsv($file, [$month, $row['income'], $row['expenses'], $row['net']]);
                    }
                    break;
            }
            
            fclose($file);
        };

        return response()->streamDownload($filename, function () use ($file) {
            echo file_get_contents('php://output');
        });
    }
}
