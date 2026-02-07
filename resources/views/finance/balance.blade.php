@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Mizania (Balance)</h1>
        <p class="text-gray-600 mt-1">Financial balance overview and summary</p>
    </div>
    
    <!-- Main Balance Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border-2 border-green-200 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-green-700 uppercase tracking-wide">Total Income</p>
                    <p class="text-4xl font-bold text-green-900 mt-3">TZS {{ number_format($totalIncome, 2) }}</p>
                </div>
                <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="pt-4 border-t border-green-200">
                <p class="text-xs text-green-600">All time income</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-8 border-2 border-red-200 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-red-700 uppercase tracking-wide">Total Expenses</p>
                    <p class="text-4xl font-bold text-red-900 mt-3">TZS {{ number_format($totalExpenses, 2) }}</p>
                </div>
                <div class="w-16 h-16 bg-red-500 rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
            <div class="pt-4 border-t border-red-200">
                <p class="text-xs text-red-600">All time expenses</p>
            </div>
        </div>
        
        <div class="bg-gradient-to-br {{ $balance >= 0 ? 'from-blue-50 to-blue-100 border-blue-200' : 'from-orange-50 to-orange-100 border-orange-200' }} rounded-xl p-8 border-2 shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm font-medium {{ $balance >= 0 ? 'text-blue-700' : 'text-orange-700' }} uppercase tracking-wide">Balance</p>
                    <p class="text-4xl font-bold {{ $balance >= 0 ? 'text-blue-900' : 'text-orange-900' }} mt-3">
                        TZS {{ number_format($balance, 2) }}
                    </p>
                </div>
                <div class="w-16 h-16 {{ $balance >= 0 ? 'bg-blue-500' : 'bg-orange-500' }} rounded-xl flex items-center justify-center shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="pt-4 border-t {{ $balance >= 0 ? 'border-blue-200' : 'border-orange-200' }}">
                <p class="text-xs {{ $balance >= 0 ? 'text-blue-600' : 'text-orange-600' }}">{{ $balance >= 0 ? 'Positive balance' : 'Negative balance' }}</p>
            </div>
        </div>
    </div>
    
    <!-- Category Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Income by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Income by Category</h2>
            <div class="space-y-3">
                @forelse($incomeByCategory as $item)
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $item->category)) }}</p>
                        </div>
                    </div>
                    <p class="text-base font-bold text-green-600">TZS {{ number_format($item->total, 2) }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No income categories found</p>
                @endforelse
            </div>
        </div>
        
        <!-- Expenses by Category -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Expenses by Category</h2>
            <div class="space-y-3">
                @forelse($expensesByCategory as $item)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $item->category)) }}</p>
                        </div>
                    </div>
                    <p class="text-base font-bold text-red-600">TZS {{ number_format($item->total, 2) }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No expense categories found</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Recent Transactions</h2>
            <a href="{{ route('finance.reports.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All Reports →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Title</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentTransactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $transaction->title }}</td>
                        <td class="px-4 py-3 text-right text-sm font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }} TZS {{ number_format($transaction->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">No transactions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
