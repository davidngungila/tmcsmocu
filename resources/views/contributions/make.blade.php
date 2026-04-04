@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">💳 Make Contribution</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Submit your contribution to the church</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('contributions.history') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Contribution History
            </a>
        </div>
    </div>

    <!-- Contribution Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('contributions.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Contribution Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Contribution Type *</label>
                    <select id="type" name="type" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select contribution type</option>
                        <option value="sadaka">Sadaka (Offering)</option>
                        <option value="zaka">Zaka (Tithe)</option>
                        <option value="fungu_la_kumi">Fungu la Kumi (Tenth)</option>
                        <option value="shukrani">Shukrani (Thanksgiving)</option>
                        <option value="michango_mingine">Michango Mingine (Other Contributions)</option>
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (TZS) *</label>
                    <input type="number" id="amount" name="amount" required min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter amount">
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
                    <select id="payment_method" name="payment_method" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Select payment method</option>
                        <option value="cash">Cash</option>
                        <option value="mobile">Mobile Money (M-Pesa, Tigo Pesa, Airtel Money)</option>
                        <option value="bank">Bank Transfer</option>
                        <option value="cheque">Cheque</option>
                    </select>
                </div>

                <!-- Transaction Reference -->
                <div>
                    <label for="transaction_reference" class="block text-sm font-medium text-gray-700 mb-2">Transaction Reference</label>
                    <input type="text" id="transaction_reference" name="transaction_reference"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter transaction ID/reference">
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    placeholder="Add any notes or special instructions"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Submit Contribution
                    </span>
                </button>
            </div>
        </form>
    </div>

    <!-- Payment Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Payment Instructions</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>For mobile payments: Use church number +255 123 456 789</li>
                        <li>For bank transfers: Account name - Church Name, Bank - ABC Bank, Account - 0123456789</li>
                        <li>For cash payments: Visit church office during working hours</li>
                        <li>Always include your name and contribution type in payment description</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
