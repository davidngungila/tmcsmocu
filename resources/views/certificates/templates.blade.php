@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Certificate Templates</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Professional templates for all spiritual groups and leadership roles</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('certificates.finalist.create') }}" 
               class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Generate Finalist
            </a>
            <a href="{{ route('certificates.group.create') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Generate Group
            </a>
        </div>
    </div>

    <!-- Spiritual Groups Templates -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Spiritual Groups Templates
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Choir Template -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-purple-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-purple-100 to-purple-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-purple-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-purple-800">Choir Certificate</h3>
                            <p class="text-sm text-purple-600 mt-1">For choir members and participants</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-purple-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('choir_standard', 'Choir Certificate')" 
                                class="flex-1 bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('choir_standard')" 
                                class="bg-purple-100 text-purple-700 px-3 py-2 rounded-lg hover:bg-purple-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Legion of Mary Template -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-blue-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-blue-100 to-blue-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-blue-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-blue-800">Legion of Mary</h3>
                            <p class="text-sm text-blue-600 mt-1">For Legion of Mary members</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('legion_mary_standard', 'Legion of Mary Certificate')" 
                                class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('legion_mary_standard')" 
                                class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Charismatic Renewal Template -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-orange-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-orange-100 to-orange-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-orange-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-orange-800">Charismatic Renewal</h3>
                            <p class="text-sm text-orange-600 mt-1">For charismatic group members</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-orange-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('charismatic_standard', 'Charismatic Renewal Certificate')" 
                                class="flex-1 bg-orange-600 text-white px-3 py-2 rounded-lg hover:bg-orange-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('charismatic_standard')" 
                                class="bg-orange-100 text-orange-700 px-3 py-2 rounded-lg hover:bg-orange-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Altar Servers Template -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-green-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-green-100 to-green-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-green-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-green-800">Altar Servers</h3>
                            <p class="text-sm text-green-600 mt-1">For altar service participants</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('altar_servers_standard', 'Altar Servers Certificate')" 
                                class="flex-1 bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('altar_servers_standard')" 
                                class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Catechists Template -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-indigo-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-indigo-100 to-indigo-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-indigo-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-indigo-800">Catechists</h3>
                            <p class="text-sm text-indigo-600 mt-1">For catechism teachers</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('catechists_standard', 'Catechists Certificate')" 
                                class="flex-1 bg-indigo-600 text-white px-3 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('catechists_standard')" 
                                class="bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg hover:bg-indigo-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Youth Ministry Template -->
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-pink-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-pink-100 to-pink-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-pink-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-pink-800">Youth Ministry</h3>
                            <p class="text-sm text-pink-600 mt-1">For youth group members</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-pink-600 text-white text-xs px-2 py-1 rounded-full">Spiritual Group</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('youth_standard', 'Youth Ministry Certificate')" 
                                class="flex-1 bg-pink-600 text-white px-3 py-2 rounded-lg hover:bg-pink-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('youth_standard')" 
                                class="bg-pink-100 text-pink-700 px-3 py-2 rounded-lg hover:bg-pink-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leadership Templates -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-yellow-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            Leadership Templates
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Community Chairperson Template -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-yellow-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-yellow-100 to-yellow-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-yellow-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-yellow-800">Community Chairperson</h3>
                            <p class="text-sm text-yellow-600 mt-1">For community leaders</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-yellow-600 text-white text-xs px-2 py-1 rounded-full">Leadership</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('leadership_chairperson', 'Community Chairperson Certificate')" 
                                class="flex-1 bg-yellow-600 text-white px-3 py-2 rounded-lg hover:bg-yellow-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('leadership_chairperson')" 
                                class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded-lg hover:bg-yellow-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Group Leader Template -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-teal-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-teal-100 to-teal-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-teal-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-teal-800">Group Leader</h3>
                            <p class="text-sm text-teal-600 mt-1">For spiritual group leaders</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-teal-600 text-white text-xs px-2 py-1 rounded-full">Leadership</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('leadership_group', 'Group Leader Certificate')" 
                                class="flex-1 bg-teal-600 text-white px-3 py-2 rounded-lg hover:bg-teal-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('leadership_group')" 
                                class="bg-teal-100 text-teal-700 px-3 py-2 rounded-lg hover:bg-teal-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Event Chairperson Template -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-red-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-red-100 to-red-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-red-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-red-800">Event Chairperson</h3>
                            <p class="text-sm text-red-600 mt-1">For event organizers</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full">Leadership</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('leadership_event', 'Event Chairperson Certificate')" 
                                class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('leadership_event')" 
                                class="bg-red-100 text-red-700 px-3 py-2 rounded-lg hover:bg-red-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Templates -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Academic Templates
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Standard Finalist Template -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-blue-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-blue-100 to-blue-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-blue-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-blue-800">Standard Finalist</h3>
                            <p class="text-sm text-blue-600 mt-1">For academic finalists</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-blue-600 text-white text-xs px-2 py-1 rounded-full">Academic</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('standard_finalist', 'Standard Finalist Certificate')" 
                                class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('standard_finalist')" 
                                class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>

            <!-- Achievement Template -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 border border-green-200">
                <div class="aspect-[3/4] bg-gradient-to-br from-green-100 to-green-200 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-20 h-20 mx-auto text-green-600 mb-2" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-green-800">Achievement</h3>
                            <p class="text-sm text-green-600 mt-1">For special achievements</p>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">Academic</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="flex space-x-2">
                        <button onclick="selectTemplate('achievement_finalist', 'Achievement Certificate')" 
                                class="flex-1 bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                            Use Template
                        </button>
                        <button onclick="previewTemplate('achievement_finalist')" 
                                class="bg-green-100 text-green-700 px-3 py-2 rounded-lg hover:bg-green-200 transition text-sm">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Selection Modal -->
<div id="templateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Template Selected</h3>
        <p class="text-gray-600 mb-6">You've selected <span id="selectedTemplateName" class="font-semibold"></span>. What would you like to do?</p>
        
        <div class="flex space-x-3">
            <button onclick="generateFinalistCertificate()" 
                    class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Generate Finalist Certificate
            </button>
            <button onclick="generateGroupCertificate()" 
                    class="flex-1 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Generate Group Certificate
            </button>
        </div>
        
        <button onclick="closeTemplateModal()" 
                class="mt-3 w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
            Cancel
        </button>
    </div>
</div>

<script>
let selectedTemplate = '';

function selectTemplate(templateKey, templateName) {
    selectedTemplate = templateKey;
    document.getElementById('selectedTemplateName').textContent = templateName;
    document.getElementById('templateModal').classList.remove('hidden');
}

function closeTemplateModal() {
    document.getElementById('templateModal').classList.add('hidden');
    selectedTemplate = '';
}

function generateFinalistCertificate() {
    window.location.href = `{{ route('certificates.finalist.create') }}?template=${selectedTemplate}`;
}

function generateGroupCertificate() {
    window.location.href = `{{ route('certificates.group.create') }}?template=${selectedTemplate}`;
}

function previewTemplate(templateKey) {
    // This would open a larger preview of the template
    alert(`Preview functionality would show a larger version of the ${templateKey} template here`);
}

// Auto-select template if passed in URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const template = urlParams.get('template');
    if (template) {
        const selectElement = document.querySelector('select[name="template_name"]');
        if (selectElement) {
            selectElement.value = template;
        }
    }
});
</script>
@endsection
