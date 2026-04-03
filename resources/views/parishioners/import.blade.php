@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Import Members</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Bulk import parishioners from Excel/CSV files</p>
        </div>
        <a href="{{ route('parishioners.index') }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>
    
    <!-- Import Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-800 mb-4">📋 Import Guidelines</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-blue-700 mb-2">Required Fields:</h4>
                <ul class="text-sm text-blue-600 space-y-1">
                    <li>• <strong>first_name</strong> - First name (required)</li>
                    <li>• <strong>last_name</strong> - Last name (required)</li>
                    <li>• <strong>member_type</strong> - student/employee/child (required)</li>
                    <li>• <strong>phone</strong> - Phone number (required)</li>
                    <li>• <strong>gender</strong> - male/female/other (required)</li>
                    <li>• <strong>date_of_birth</strong> - YYYY-MM-DD format (required)</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-blue-700 mb-2">Optional Fields:</h4>
                <ul class="text-sm text-blue-600 space-y-1">
                    <li>• <strong>middle_name</strong> - Middle name</li>
                    <li>• <strong>email</strong> - Email address</li>
                    <li>• <strong>address</strong> - Physical address</li>
                    <li>• <strong>occupation</strong> - Occupation</li>
                    <li>• <strong>notes</strong> - Additional notes</li>
                </ul>
            </div>
        </div>
        
        <div class="mt-4">
            <h4 class="font-semibold text-blue-700 mb-2">Student-Specific Fields:</h4>
            <ul class="text-sm text-blue-600 space-y-1">
                <li>• <strong>registration_number</strong> - MoCU registration number (format: MoCU/XXX/XXX/XX)</li>
                <li>• <strong>academic_programme</strong> - BBICT/BAPSM/LL.B/BHRM/BBA/BED</li>
                <li>• <strong>year_of_study</strong> - 1/2/3/4/alumni</li>
            </ul>
        </div>
        
        <div class="mt-4">
            <h4 class="font-semibold text-blue-700 mb-2">Employee-Specific Fields:</h4>
            <ul class="text-sm text-blue-600 space-y-1">
                <li>• <strong>employee_id</strong> - Employee ID</li>
                <li>• <strong>department</strong> - Department name</li>
            </ul>
        </div>
        
        <div class="mt-4">
            <h4 class="font-semibold text-blue-700 mb-2">Child-Specific Fields:</h4>
            <ul class="text-sm text-blue-600 space-y-1">
                <li>• <strong>guardian_name</strong> - Guardian's full name</li>
                <li>• <strong>guardian_phone</strong> - Guardian's phone number</li>
                <li>• <strong>guardian_email</strong> - Guardian's email</li>
            </ul>
        </div>
    </div>
    
    <!-- Sample Template Download -->
    <div class="bg-green-50 border border-green-200 rounded-xl p-6">
        <h3 class="text-lg font-bold text-green-800 mb-4">📥 Download Sample Template</h3>
        <p class="text-sm text-green-600 mb-4">Use our sample template to ensure your data is formatted correctly:</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ asset('templates/parishioners_import_template.csv') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download CSV Template
            </a>
            <a href="{{ asset('templates/parishioners_import_template.xlsx') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download Excel Template
            </a>
        </div>
        <p class="text-xs text-green-600 mt-2">💡 CSV template recommended for best compatibility</p>
    </div>
    
    <!-- Import Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📤 Upload File</h3>
        <form method="POST" action="{{ route('parishioners.import.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- File Upload -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Select File <span class="text-red-500">*</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                    <input type="file" name="import_file" accept=".xlsx,.xls,.csv" class="hidden" id="fileInput" onchange="handleFileSelect(this)">
                    <label for="fileInput" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500 mt-1">Excel (.xlsx, .xls) or CSV files only</p>
                        <p class="text-xs text-gray-500">Maximum file size: 10MB</p>
                    </label>
                    <div id="fileInfo" class="hidden mt-4">
                        <p class="text-sm font-medium text-green-600">File selected: <span id="fileName"></span></p>
                    </div>
                </div>
                @error('import_file')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Import Options -->
            <div class="border-t border-gray-200 pt-6">
                <h4 class="font-semibold text-gray-800 mb-4">Import Options</h4>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="skip_duplicates" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2" checked>
                        <span class="text-sm text-gray-700">Skip duplicate records (based on phone number)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="send_welcome" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2">
                        <span class="text-sm text-gray-700">Send welcome SMS/email to imported members</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="update_existing" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2">
                        <span class="text-sm text-gray-700">Update existing members if found</span>
                    </label>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('parishioners.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Import Members
                </button>
            </div>
        </form>
    </div>
    
    <!-- Recent Imports History -->
    @if(isset($recentImports) && $recentImports->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Recent Import History</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">File Name</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Records</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Success</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Failed</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentImports as $import)
                    <tr>
                        <td class="px-4 py-3 text-gray-900">{{ $import->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 text-gray-900">{{ $import->file_name }}</td>
                        <td class="px-4 py-3 text-gray-900">{{ $import->total_records }}</td>
                        <td class="px-4 py-3 text-green-600">{{ $import->successful_imports }}</td>
                        <td class="px-4 py-3 text-red-600">{{ $import->failed_imports }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                                $import->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                ($import->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800') 
                            }}">
                                {{ ucfirst($import->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($import->status === 'completed' && $import->failed_imports > 0)
                            <a href="{{ route('parishioners.import.errors', $import->id) }}" class="text-red-600 hover:text-red-900 text-sm">
                                View Errors
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
function handleFileSelect(input) {
    const file = input.files[0];
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    
    if (file) {
        // Check file size (10MB limit)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            alert('File size exceeds 10MB limit. Please choose a smaller file.');
            input.value = '';
            return;
        }
        
        // Check file type
        const allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'];
        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please upload an Excel (.xlsx, .xls) or CSV file.');
            input.value = '';
            return;
        }
        
        fileName.textContent = file.name;
        fileInfo.classList.remove('hidden');
    } else {
        fileInfo.classList.add('hidden');
    }
}

// Drag and drop functionality
const dropZone = document.querySelector('[for="fileInput"]');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.parentElement.classList.add('border-purple-500', 'bg-purple-50');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.parentElement.classList.remove('border-purple-500', 'bg-purple-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.parentElement.classList.remove('border-purple-500', 'bg-purple-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('fileInput').files = files;
        handleFileSelect(document.getElementById('fileInput'));
    }
});
</script>
@endsection
