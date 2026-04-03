@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">TmcsSmart – Parishioner Registration Form</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Complete registration form for Students, Employees, and Children</p>
        </div>
        <a href="{{ route('parishioners.index', ['type' => request('type', 'wanafunzi')]) }}" class="text-gray-600 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>
    
    <!-- Important Notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
        <h3 class="text-sm font-bold text-blue-800 mb-2">📋 Registration Guidelines</h3>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>• <strong>Students:</strong> Must provide MoCU registration number (format: MoCU/XXX/XXX/XX)</li>
            <li>• <strong>Children:</strong> Must be under 18 years and linked to a guardian</li>
            <li>• <strong>Phone Number:</strong> Required for SMS receipts (Tanzanian format: 07XX XXX XXX or 2557XX XXX XXX)</li>
            <li>• <strong>Photo:</strong> Required for certificates (max 5MB, JPEG/PNG)</li>
        </ul>
    </div>
    
    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('parishioners.store') }}" enctype="multipart/form-data" class="space-y-8" id="registrationForm">
            @csrf
            
            <!-- Member Type Selection -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">👤 Member Type <span class="text-red-500">*</span></h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="member_type" value="student" required 
                               class="peer sr-only" onchange="toggleMemberFields(this.value)"
                               {{ old('member_type') == 'student' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Student (Wanafunzi)</p>
                                    <p class="text-xs text-gray-500">MoCU student with registration number</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="member_type" value="employee" required 
                               class="peer sr-only" onchange="toggleMemberFields(this.value)"
                               {{ old('member_type') == 'employee' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Employee (Mfanyakazi)</p>
                                    <p class="text-xs text-gray-500">Staff member with department</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="member_type" value="child" required 
                               class="peer sr-only" onchange="toggleMemberFields(this.value)"
                               {{ old('member_type') == 'child' ? 'checked' : '' }}>
                        <div class="border-2 rounded-lg p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Child (Mtoto)</p>
                                    <p class="text-xs text-gray-500">Under 18, linked to guardian</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('member_type')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Student Specific Fields -->
            <div id="studentFields" class="{{ old('member_type') == 'student' ? '' : 'hidden' }}">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🎓 Student Information</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800"><strong>For Students Only:</strong> Academic information for community assignment</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Registration Number <span class="text-red-500">*</span></label>
                        <input type="text" name="registration_number" value="{{ old('registration_number') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., MoCU/BICT/166/24" pattern="MoCU/[A-Z]{3,4}/[0-9]{1,4}/[0-9]{2}">
                        <p class="text-xs text-gray-500 mt-1">Format: MoCU/XXX/XXX/XX or MoCU/XXXX/XXX/XX</p>
                        @error('registration_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Academic Programme <span class="text-red-500">*</span></label>
                        <select name="academic_programme" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Programme</option>
                            <option value="BBICT" {{ old('academic_programme') == 'BBICT' ? 'selected' : '' }}>BBICT - Bachelor of Business ICT</option>
                            <option value="BAPSM" {{ old('academic_programme') == 'BAPSM' ? 'selected' : '' }}>BAPSM - Bachelor of Arts Pastoral Studies</option>
                            <option value="LL.B" {{ old('academic_programme') == 'LL.B' ? 'selected' : '' }}>LL.B - Bachelor of Laws</option>
                            <option value="BHRM" {{ old('academic_programme') == 'BHRM' ? 'selected' : '' }}>BHRM - Bachelor of Human Resource Management</option>
                            <option value="BBA" {{ old('academic_programme') == 'BBA' ? 'selected' : '' }}>BBA - Bachelor of Business Administration</option>
                            <option value="BED" {{ old('academic_programme') == 'BED' ? 'selected' : '' }}>BED - Bachelor of Education</option>
                        </select>
                        @error('academic_programme')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Year of Study <span class="text-red-500">*</span></label>
                        <select name="year_of_study" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Year</option>
                            <option value="1" {{ old('year_of_study') == '1' ? 'selected' : '' }}>Year 1</option>
                            <option value="2" {{ old('year_of_study') == '2' ? 'selected' : '' }}>Year 2</option>
                            <option value="3" {{ old('year_of_study') == '3' ? 'selected' : '' }}>Year 3</option>
                            <option value="4" {{ old('year_of_study') == '4' ? 'selected' : '' }}>Year 4</option>
                            <option value="alumni" {{ old('year_of_study') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                        @error('year_of_study')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="lg:col-span-3">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Class-Specific Link Code</label>
                        <input type="text" name="class_link_code" value="{{ old('class_link_code', request('link_code')) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Auto-filled when using coordinator's unique link" readonly>
                        <p class="text-xs text-gray-500 mt-1">Provided by Spiritual Coordinator for class-specific registration</p>
                    </div>
                </div>
            </div>
            
            <!-- Employee Specific Fields -->
            <div id="employeeFields" class="{{ old('member_type') == 'employee' ? '' : 'hidden' }}">
                <h3 class="text-lg font-bold text-gray-800 mb-4">💼 Employee Information</h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-green-800"><strong>For Employees Only:</strong> Department and role information</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Employee ID</label>
                        <input type="text" name="employee_id" value="{{ old('employee_id') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., EMP001">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Department / Unit <span class="text-red-500">*</span></label>
                        <select name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Department</option>
                            <option value="Academic" {{ old('department') == 'Academic' ? 'selected' : '' }}>Academic</option>
                            <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration</option>
                            <option value="Library" {{ old('department') == 'Library' ? 'selected' : '' }}>Library</option>
                            <option value="ICT" {{ old('department') == 'ICT' ? 'selected' : '' }}>ICT</option>
                            <option value="Chaplaincy" {{ old('department') == 'Chaplaincy' ? 'selected' : '' }}>Chaplaincy</option>
                            <option value="Maintenance" {{ old('department') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('department')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Child Specific Fields -->
            <div id="childFields" class="{{ old('member_type') == 'child' ? '' : 'hidden' }}">
                <h3 class="text-lg font-bold text-gray-800 mb-4">👶 Child Information</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-yellow-800"><strong>For Children Only:</strong> Must be under 18 and linked to guardian</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               max="{{ now()->subYears(18)->format('Y-m-d') }}">
                        <p class="text-xs text-gray-500 mt-1">Must be under 18 years old</p>
                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Guardian Name <span class="text-red-500">*</span></label>
                        <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Guardian's full name">
                        @error('guardian_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Guardian Phone <span class="text-red-500">*</span></label>
                        <input type="tel" name="guardian_phone" value="{{ old('guardian_phone') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="0712345678 or 255712345678" pattern="(07[0-9]{8}|255[0-9]{9})">
                        <p class="text-xs text-gray-500 mt-1">Must match existing member</p>
                        @error('guardian_phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Guardian Email</label>
                        <input type="email" name="guardian_email" value="{{ old('guardian_email') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="guardian@email.com">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Guardian (Existing Member)</label>
                        <select name="guardian_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Guardian</option>
                            @foreach($parishioners ?? [] as $parishioner)
                                @if($parishioner->member_type === 'employee' || $parishioner->member_type === 'student')
                                    <option value="{{ $parishioner->id }}" {{ old('guardian_id') == $parishioner->id ? 'selected' : '' }}>{{ $parishioner->full_name }} ({{ $parishioner->member_type_label }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('middle_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                        <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Format: mm/dd/yyyy</p>
                        @error('date_of_birth')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Photo <span class="text-gray-500">(Optional for first registration, required for certificates)</span></label>
                        <input type="file" name="photo" accept="image/jpeg,image/png" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">JPEG/PNG, max 5MB (required for certificate generation)</p>
                        @error('photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">📞 Contact Information (Important for Receiving Receipts and Messages)</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800">
                        <strong>Important:</strong> Phone number is required for SMS receipts. Email is recommended for PDF receipts and notifications.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                               placeholder="e.g., 0712345678 or 255712345678"
                               pattern="(07[0-9]{8}|255[0-9]{9})"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Tanzanian format: 07XX XXX XXX or 2557XX XXX XXX</p>
                        <p class="text-xs text-gray-500">Used for SMS thank you messages and receipts</p>
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address <span class="text-blue-500">(Recommended)</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="e.g., name@email.com"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <p class="text-xs text-gray-500 mt-1">Used to send PDF receipts and notifications</p>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Physical Address</label>
                        <textarea name="address" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="e.g., street, village, city">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Additional Information -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">ℹ️ Additional Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Occupation</label>
                        <input type="text" name="occupation" value="{{ old('occupation') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., Student, Lecturer, Accountant">
                        @error('occupation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Spiritual Community</label>
                        <select name="spiritual_community_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Auto-assigned based on programme</option>
                            @foreach($spiritualCommunities ?? [] as $community)
                                <option value="{{ $community->id }}" {{ old('spiritual_community_id') == $community->id ? 'selected' : '' }}>{{ $community->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Auto-assigned for students based on academic programme</p>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Spiritual Groups</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="choir" class="mr-2">
                                <span class="text-sm">Choir</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="legion_mary" class="mr-2">
                                <span class="text-sm">Legion of Mary</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="charismatic" class="mr-2">
                                <span class="text-sm">Charismatic Renewal</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="altar_servers" class="mr-2">
                                <span class="text-sm">Altar Servers</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="catechists" class="mr-2">
                                <span class="text-sm">Catechists</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="spiritual_groups[]" value="youth" class="mr-2">
                                <span class="text-sm">Youth Ministry</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Any additional information">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Consent & Privacy -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">🔒 Consent & Privacy</h3>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" name="privacy_consent" required class="mt-1 mr-3">
                        <div>
                            <p class="text-sm text-gray-800">
                                <strong>I agree to the Privacy Policy</strong> and consent to my data being used for chaplaincy administration, receipt generation, and communication.
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                Your information will be handled according to our data protection policies and will only be used for chaplaincy-related purposes.
                            </p>
                        </div>
                    </label>
                    @error('privacy_consent')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    <p>Fields marked with <span class="text-red-500">*</span> are required</p>
                    <p class="mt-1">Phone number is required for SMS receipts</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('parishioners.index', ['type' => request('type', 'wanafunzi')]) }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                        Register Parishioner
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function toggleMemberFields(type) {
    // Hide all type-specific sections
    document.getElementById('studentFields').classList.add('hidden');
    document.getElementById('employeeFields').classList.add('hidden');
    document.getElementById('childFields').classList.add('hidden');
    
    // Show relevant section
    if (type === 'student') {
        document.getElementById('studentFields').classList.remove('hidden');
    } else if (type === 'employee') {
        document.getElementById('employeeFields').classList.remove('hidden');
    } else if (type === 'child') {
        document.getElementById('childFields').classList.remove('hidden');
    }
    
    // Update required fields based on type
    updateRequiredFields(type);
}

function updateRequiredFields(type) {
    // For children, date of birth is already shown in child section
    // For other types, personal date of birth is optional
    const personalDOB = document.querySelector('input[name="date_of_birth"]:not(#childFields input[name="date_of_birth"])');
    if (personalDOB) {
        if (type === 'child') {
            personalDOB.removeAttribute('required');
        } else {
            personalDOB.setAttribute('required', '');
        }
    }
}

// Phone number validation
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Format phone number as user types
            let value = e.target.value.replace(/\D/g, '');
            
            // Allow Tanzania formats
            if (value.startsWith('255') && value.length <= 12) {
                if (value.length > 8) {
                    value = value.slice(0, 9) + ' ' + value.slice(9, 12) + ' ' + value.slice(12);
                }
            } else if (value.startsWith('07') && value.length <= 10) {
                if (value.length > 6) {
                    value = value.slice(0, 6) + ' ' + value.slice(6);
                }
            }
            
            e.target.value = value;
        });
    }
    
    // Initialize based on current value
    const memberTypeSelect = document.querySelector('input[name="member_type"]:checked');
    if (memberTypeSelect) {
        toggleMemberFields(memberTypeSelect.value);
    }
});

// Form validation
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    const memberType = document.querySelector('input[name="member_type"]:checked');
    const phone = document.querySelector('input[name="phone"]').value;
    
    // Validate phone format
    const phonePattern = /^(07[0-9]{8}|255[0-9]{9})$/;
    if (!phonePattern.test(phone.replace(/\s/g, ''))) {
        e.preventDefault();
        alert('Please enter a valid Tanzanian phone number format: 07XX XXX XXX or 2557XX XXX XXX');
        return;
    }
    
    // For children, validate age
    if (memberType && memberType.value === 'child') {
        const dob = document.querySelector('#childFields input[name="date_of_birth"]').value;
        const age = calculateAge(new Date(dob));
        if (age >= 18) {
            e.preventDefault();
            alert('Children must be under 18 years old');
            return;
        }
    }
    
    // For students, validate registration number
    if (memberType && memberType.value === 'student') {
        const regNumber = document.querySelector('input[name="registration_number"]').value;
        const regPattern = /^MoCU\/[A-Z]{3,4}\/[0-9]{1,4}\/[0-9]{2}$/;
        if (!regPattern.test(regNumber)) {
            e.preventDefault();
            alert('Registration number must be in format: MoCU/XXX/XXX/XX or MoCU/XXXX/XXX/XX');
            return;
        }
    }
});

function calculateAge(birthDate) {
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    return age;
}
</script>
@endsection

