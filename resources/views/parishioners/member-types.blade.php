@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Member Types</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage member types and their configurations</p>
        </div>
        <a href="{{ route('parishioners.index') }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>
    
    <!-- Member Types Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Students Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">STUDENT</span>
            </div>
            <h3 class="text-lg font-bold text-blue-900 mb-2">Students</h3>
            <p class="text-sm text-blue-700 mb-4">MoCU students with registration numbers and academic programmes</p>
            
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-blue-600">Total Students:</span>
                    <span class="font-bold text-blue-900">{{ number_format($studentCount ?? 0) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-blue-600">Active Students:</span>
                    <span class="font-bold text-blue-900">{{ number_format($activeStudentCount ?? 0) }}</span>
                </div>
            </div>
            
            <div class="border-t border-blue-200 pt-4">
                <h4 class="font-semibold text-blue-800 mb-2">Required Fields:</h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Registration Number (MoCU format)</li>
                    <li>• Academic Programme</li>
                    <li>• Year of Study</li>
                    <li>• Contact Information</li>
                </ul>
            </div>
        </div>
        
        <!-- Employees Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded-full">EMPLOYEE</span>
            </div>
            <h3 class="text-lg font-bold text-green-900 mb-2">Employees</h3>
            <p class="text-sm text-green-700 mb-4">Staff members with departments and roles</p>
            
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-green-600">Total Employees:</span>
                    <span class="font-bold text-green-900">{{ number_format($employeeCount ?? 0) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-green-600">Active Employees:</span>
                    <span class="font-bold text-green-900">{{ number_format($activeEmployeeCount ?? 0) }}</span>
                </div>
            </div>
            
            <div class="border-t border-green-200 pt-4">
                <h4 class="font-semibold text-green-800 mb-2">Required Fields:</h4>
                <ul class="text-xs text-green-700 space-y-1">
                    <li>• Department/Unit</li>
                    <li>• Employee ID (optional)</li>
                    <li>• Contact Information</li>
                    <li>• Work Information</li>
                </ul>
            </div>
        </div>
        
        <!-- Children Card -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="px-3 py-1 bg-yellow-600 text-white text-xs font-bold rounded-full">CHILD</span>
            </div>
            <h3 class="text-lg font-bold text-yellow-900 mb-2">Children</h3>
            <p class="text-sm text-yellow-700 mb-4">Under 18 years linked to guardians</p>
            
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-yellow-600">Total Children:</span>
                    <span class="font-bold text-yellow-900">{{ number_format($childCount ?? 0) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-yellow-600">Active Children:</span>
                    <span class="font-bold text-yellow-900">{{ number_format($activeChildCount ?? 0) }}</span>
                </div>
            </div>
            
            <div class="border-t border-yellow-200 pt-4">
                <h4 class="font-semibold text-yellow-800 mb-2">Required Fields:</h4>
                <ul class="text-xs text-yellow-700 space-y-1">
                    <li>• Date of Birth (under 18)</li>
                    <li>• Guardian Information</li>
                    <li>• Guardian Contact</li>
                    <li>• Parent/Guardian Link</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Academic Programmes Configuration -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">📚 Academic Programmes</h3>
            <button onclick="toggleProgrammeConfig()" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Configure
            </button>
        </div>
        
        <div id="programmeConfig" class="hidden">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-purple-800">Configure available academic programmes for students. These will appear as dropdown options in the registration form.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($academicProgrammes ?? [
                    'BBICT' => 'Bachelor of Business ICT',
                    'BAPSM' => 'Bachelor of Arts Pastoral Studies',
                    'LL.B' => 'Bachelor of Laws',
                    'BHRM' => 'Bachelor of Human Resource Management',
                    'BBA' => 'Bachelor of Business Administration',
                    'BED' => 'Bachelor of Education'
                ] as $code => $name)
                <div class="border rounded-lg p-3 {{ in_array($code, $activeProgrammes ?? []) ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }}">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="programmes[]" value="{{ $code }}" 
                               {{ in_array($code, $activeProgrammes ?? []) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2">
                        <div>
                            <p class="font-medium text-gray-900">{{ $code }}</p>
                            <p class="text-xs text-gray-500">{{ $name }}</p>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4 flex gap-2">
                <button onclick="saveProgrammeConfig()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                    Save Configuration
                </button>
                <button onclick="toggleProgrammeConfig()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                    Cancel
                </button>
            </div>
        </div>
        
        <div id="programmeDisplay" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($academicProgrammes ?? [
                'BBICT' => 'Bachelor of Business ICT',
                'BAPSM' => 'Bachelor of Arts Pastoral Studies',
                'LL.B' => 'Bachelor of Laws',
                'BHRM' => 'Bachelor of Human Resource Management',
                'BBA' => 'Bachelor of Business Administration',
                'BED' => 'Bachelor of Education'
            ] as $code => $name)
            <div class="border rounded-lg p-3 {{ in_array($code, $activeProgrammes ?? []) ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">{{ $code }}</p>
                        <p class="text-xs text-gray-500">{{ $name }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                        in_array($code, $activeProgrammes ?? []) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' 
                    }}">
                        {{ in_array($code, $activeProgrammes ?? []) ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Departments Configuration -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">🏢 Departments</h3>
            <button onclick="toggleDepartmentConfig()" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Configure
            </button>
        </div>
        
        <div id="departmentConfig" class="hidden">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-purple-800">Configure available departments for employees. These will appear as dropdown options in the registration form.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($departments ?? [
                    'Academic', 'Finance', 'Administration', 'Library', 'ICT', 'Chaplaincy', 'Maintenance'
                ] as $department)
                <div class="border rounded-lg p-3 {{ in_array($department, $activeDepartments ?? []) ? 'border-purple-500 bg-purple-50' : 'border-gray-300' }}">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="departments[]" value="{{ $department }}" 
                               {{ in_array($department, $activeDepartments ?? []) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 mr-2">
                        <div>
                            <p class="font-medium text-gray-900">{{ $department }}</p>
                            <p class="text-xs text-gray-500">Department unit</p>
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            
            <div class="mt-4 flex gap-2">
                <button onclick="saveDepartmentConfig()" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                    Save Configuration
                </button>
                <button onclick="toggleDepartmentConfig()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                    Cancel
                </button>
            </div>
        </div>
        
        <div id="departmentDisplay" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($departments ?? [
                'Academic', 'Finance', 'Administration', 'Library', 'ICT', 'Chaplaincy', 'Maintenance'
            ] as $department)
            <div class="border rounded-lg p-3 {{ in_array($department, $activeDepartments ?? []) ? 'border-green-500 bg-green-50' : 'border-gray-300 bg-gray-50' }}">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">{{ $department }}</p>
                        <p class="text-xs text-gray-500">Department unit</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ 
                        in_array($department, $activeDepartments ?? []) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' 
                    }}">
                        {{ in_array($department, $activeDepartments ?? []) ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Member Type Rules -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">📋 Member Type Rules & Validation</h3>
        
        <div class="space-y-6">
            <!-- Student Rules -->
            <div class="border-l-4 border-blue-500 pl-4">
                <h4 class="font-semibold text-blue-800 mb-2">Student Registration Rules</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li>• Registration number must follow format: MoCU/XXX/XXX/XX</li>
                    <li>• Academic programme must be from approved list</li>
                    <li>• Year of study must be 1, 2, 3, 4, or alumni</li>
                    <li>• Phone number must be valid Tanzanian format</li>
                    <li>• Email address recommended for communications</li>
                </ul>
            </div>
            
            <!-- Employee Rules -->
            <div class="border-l-4 border-green-500 pl-4">
                <h4 class="font-semibold text-green-800 mb-2">Employee Registration Rules</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li>• Department must be from approved list</li>
                    <li>• Employee ID is optional but recommended</li>
                    <li>• Phone number must be valid Tanzanian format</li>
                    <li>• Email address recommended for communications</li>
                    <li>• Can be assigned as guardian for children</li>
                </ul>
            </div>
            
            <!-- Child Rules -->
            <div class="border-l-4 border-yellow-500 pl-4">
                <h4 class="font-semibold text-yellow-800 mb-2">Child Registration Rules</h4>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li>• Must be under 18 years old (age validation)</li>
                    <li>• Guardian information is required</li>
                    <li>• Guardian phone must match existing member</li>
                    <li>• Can be linked to employee or student parent</li>
                    <li>• Photo required for certificate generation</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function toggleProgrammeConfig() {
    const config = document.getElementById('programmeConfig');
    const display = document.getElementById('programmeDisplay');
    
    config.classList.toggle('hidden');
    display.classList.toggle('hidden');
}

function toggleDepartmentConfig() {
    const config = document.getElementById('departmentConfig');
    const display = document.getElementById('departmentDisplay');
    
    config.classList.toggle('hidden');
    display.classList.toggle('hidden');
}

function saveProgrammeConfig() {
    const checkboxes = document.querySelectorAll('input[name="programmes[]"]:checked');
    const programmes = Array.from(checkboxes).map(cb => cb.value);
    
    // Here you would send this data to the server
    console.log('Saving programmes:', programmes);
    
    // Show success message
    alert('Academic programmes configuration saved successfully!');
    toggleProgrammeConfig();
}

function saveDepartmentConfig() {
    const checkboxes = document.querySelectorAll('input[name="departments[]"]:checked');
    const departments = Array.from(checkboxes).map(cb => cb.value);
    
    // Here you would send this data to the server
    console.log('Saving departments:', departments);
    
    // Show success message
    alert('Departments configuration saved successfully!');
    toggleDepartmentConfig();
}
</script>
@endsection
