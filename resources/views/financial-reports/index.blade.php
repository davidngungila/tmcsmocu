@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📊 Financial Reports</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Comprehensive financial analysis and reporting</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="generateReport()" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Generate Report
            </button>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z"></path>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    <!-- Report Period Selection -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📅 Report Period</h3>
        <form method="GET" action="{{ route('financial-reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Financial Year</label>
                <select name="financial_year_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Years</option>
                    @foreach($financialYears as $year)
                        <option value="{{ $year->id }}" {{ request('financial_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }} ({{ $year->start_date->format('Y') }}-{{ $year->end_date->format('Y') }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="summary" {{ request('report_type') == 'summary' ? 'selected' : '' }}>Summary Report</option>
                    <option value="contributions" {{ request('report_type') == 'contributions' ? 'selected' : '' }}>Contributions Detail</option>
                    <option value="expenses" {{ request('report_type') == 'expenses' ? 'selected' : '' }}>Expenses Detail</option>
                    <option value="cash_flow" {{ request('report_type') == 'cash_flow' ? 'selected' : '' }}>Cash Flow Statement</option>
                    <option value="balance_sheet" {{ request('report_type') == 'balance_sheet' ? 'selected' : '' }}>Balance Sheet</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') ?? now()->startOfMonth()->format('Y-m-d') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') ?? now()->format('Y-m-d') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Income</p>
                    <p class="text-2xl font-bold text-green-600">TSh {{ number_format($totalIncome, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .434-3 3s.434 3 3 3 3-.434 3-3 3-.434 3-3 3zm0 0l6 6m-6-6l6 6m6-6v6a2 2 0 002 2h2a2 2 0 002-2v-6m-6 0v6a2 2 0 002 2h2a2 2 0 002-2v-6"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Expenses</p>
                    <p class="text-2xl font-bold text-red-600">TSh {{ number_format($totalExpenses, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Net Balance</p>
                    <p class="text-2xl font-bold {{ $netBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}">TSh {{ number_format($netBalance, 0) }}</p>
                </div>
                <div class="w-12 h-12 {{ $netBalance >= 0 ? 'bg-blue-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $netBalance >= 0 ? 'text-blue-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($totalTransactions, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Tables -->
    @if(request('report_type') == 'contributions' || !request('report_type'))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">💰 Contributions Breakdown</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contributionBreakdown as $type => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                    {{ \App\Models\Contribution::TYPES[$type] ?? $type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['count'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TSh {{ number_format($data['total'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ number_format($data['percentage'], 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(request('report_type') == 'expenses' || !request('report_type'))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">💸 Expenses Breakdown</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expenseBreakdown as $category => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ \App\Models\Expense::CATEGORIES[$category] ?? $category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $data['count'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TSh {{ number_format($data['total'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ number_format($data['percentage'], 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(request('report_type') == 'cash_flow' || !request('report_type'))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">💵 Cash Flow Statement</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Flow</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cashFlow as $month => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">TSh {{ number_format($data['income'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">TSh {{ number_format($data['expenses'], 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $data['net'] >= 0 ? 'text-green-600' : 'text-red-600' }}">TSh {{ number_format($data['net'], 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📤 Export Options</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('financial-reports.export', ['format' => 'pdf']) }}" class="flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0015.586 4H6a1 1 0 00-1 1v10a1 1 0 001 1h1m-6 0l6 6"></path>
                </svg>
                Export PDF
            </a>
            <a href="{{ route('financial-reports.export', ['format' => 'excel']) }}" class="flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h6a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2H6a2 2 0 00-2 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                </svg>
                Export Excel
            </a>
            <a href="{{ route('financial-reports.export', ['format' => 'csv']) }}" class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2z"></path>
                </svg>
                Export CSV
            </a>
        </div>
    </div>
</div>
@endsection
