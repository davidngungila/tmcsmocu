@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Annual Report</h1>
            <p class="text-gray-600 mt-1">Financial overview for {{ $year }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <input type="number" value="{{ $year }}" min="2020" max="2099" onchange="window.location.href='{{ route('finance.reports.annual') }}?year=' + this.value" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent w-32">
            <a href="{{ route('finance.reports.annual.pdf', ['year' => $year]) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-bold flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Export PDF</span>
            </a>
            <a href="{{ route('finance.reports.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Back to Reports
            </a>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Total Income</p>
                    <p class="text-2xl font-bold text-green-900 mt-2">TZS {{ number_format($income, 2) }}</p>
                </div>
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-700">Total Expenses</p>
                    <p class="text-2xl font-bold text-red-900 mt-2">TZS {{ number_format($expenses, 2) }}</p>
                </div>
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Net Balance</p>
                    <p class="text-2xl font-bold text-blue-900 mt-2">TZS {{ number_format($income - $expenses, 2) }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Monthly Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Monthly Breakdown</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            @endphp
            @foreach($months as $index => $monthName)
                @php
                    $monthData = $monthlyData->firstWhere('month', $index + 1);
                    $monthIncome = $monthData->income ?? 0;
                    $monthExpense = $monthData->expense ?? 0;
                @endphp
                <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                    <h3 class="text-sm font-bold text-gray-700 mb-3">{{ $monthName }}</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-green-600">Income:</span>
                            <span class="text-xs font-bold text-green-600">TZS {{ number_format($monthIncome, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-red-600">Expense:</span>
                            <span class="text-xs font-bold text-red-600">TZS {{ number_format($monthExpense, 2) }}</span>
                        </div>
                        <div class="pt-2 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-xs font-medium text-gray-700">Balance:</span>
                            <span class="text-xs font-bold {{ ($monthIncome - $monthExpense) >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                                TZS {{ number_format($monthIncome - $monthExpense, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Transactions Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">All Transactions ({{ $transactions->count() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Title</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactions->take(20) as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $transaction->title }}</td>
                        <td class="px-6 py-4 text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} TZS {{ number_format($transaction->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">No transactions found for this year</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->count() > 20)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center">
            <p class="text-sm text-gray-600">Showing first 20 of {{ $transactions->count() }} transactions</p>
        </div>
        @endif
    </div>
</div>
@endsection

