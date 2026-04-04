@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Import Contributions</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Bulk import contributions from Excel or CSV files</p>
        </div>
        <div class="flex items-center space-x-2 text-xs sm:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="hidden sm:inline">Home > Finance > Contributions > Import</span>
            <span class="sm:hidden">Import Contributions</span>
        </div>
    </div>

    <!-- Import Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Import Instructions</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Download the template file below and fill it with your contribution data</li>
                        <li>Required columns: Parishioner ID, Amount, Contribution Type, Payment Method, Date</li>
                        <li>Optional columns: Reference Number, Notes</li>
                        <li>Save your file as Excel (.xlsx) or CSV (.csv) format</li>
                        <li>Upload the completed file using the form below</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Download -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">📥 Download Template</h2>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ asset('templates/contributions_import_template.xlsx') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel Template
            </a>
            <a href="{{ asset('templates/contributions_import_template.csv') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download CSV Template
            </a>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Upload Contributions File</h2>
            <p class="text-sm text-gray-600 mt-1">Select your completed Excel or CSV file to import</p>
        </div>
        
        <form action="{{ route('finance.contributions.import.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                    Select File <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="file" id="file" name="file" required
                           accept=".xlsx,.xls,.csv"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <p class="mt-2 text-xs text-gray-500">Accepted formats: .xlsx, .xls, .csv (Maximum file size: 10MB)</p>
            </div>

            <!-- Financial Year Selection -->
            <div>
                <label for="financial_year_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Default Financial Year
                </label>
                <select id="financial_year_id" name="financial_year_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">Use file's financial year (if specified)</option>
                    @foreach(\App\Models\FinancialYear::orderBy('start_date', 'desc')->get() as $financialYear)
                        <option value="{{ $financialYear->id }}"
                                @if($financialYear->is_active) selected @endif>
                            {{ $financialYear->name }} @if($financialYear->is_active) (Active) @endif
                        </option>
                    @endforeach
                </select>
                <p class="mt-2 text-xs text-gray-500">This will be used if the file doesn't specify a financial year</p>
            </div>

            <!-- Import Options -->
            <div class="space-y-4">
                <h3 class="text-sm font-medium text-gray-700">Import Options</h3>
                
                <div class="flex items-center">
                    <input type="checkbox" id="skip_duplicates" name="skip_duplicates" value="1" checked
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="skip_duplicates" class="ml-2 text-sm text-gray-700">
                        Skip duplicate contributions
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="validate_parishioners" name="validate_parishioners" value="1" checked
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="validate_parishioners" class="ml-2 text-sm text-gray-700">
                        Validate parishioner IDs
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="generate_receipts" name="generate_receipts" value="1"
                           class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="generate_receipts" class="ml-2 text-sm text-gray-700">
                        Generate receipts for imported contributions
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 sm:flex-none px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0c0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6m-6 0v4"></path>
                        </svg>
                        Import Contributions
                    </span>
                </button>
                
                <a href="{{ route('finance.contributions.index') }}" class="flex-1 sm:flex-none px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Recent Imports -->
    @if(isset($recentImports) && $recentImports->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Recent Imports</h2>
            <p class="text-sm text-gray-600 mt-1">Your latest contribution imports</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Records</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imported By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentImports as $import)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $import->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $import->file_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $import->total_records }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($import->status == 'completed') bg-green-100 text-green-800
                                @elseif($import->status == 'processing') bg-yellow-100 text-yellow-800
                                @elseif($import->status == 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($import->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $import->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('finance.contributions.import.show', $import) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Import Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Total Imports</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">24</p>
                </div>
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 4L13 4m0 0l-4 4a5 5 0 01-9.9 0A4 4 0 017 16m0 0c0 1.657 3.583 3 4.003 5.417.417.417 0 00-.417-.417m-6 0v4m0 0h6m-6 0v4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Records Imported</p>
                    <p class="text-2xl font-bold text-blue-900 mt-1">1,847</p>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">This Month</p>
                    <p class="text-2xl font-bold text-purple-900 mt-1">3</p>
                </div>
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-700">Success Rate</p>
                    <p class="text-2xl font-bold text-orange-900 mt-1">98.5%</p>
                </div>
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
