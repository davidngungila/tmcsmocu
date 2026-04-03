@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">🌍 Tanzania Locations</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Interactive hierarchical location browser</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('locations.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Location
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    @if(session('import_errors'))
                        <div class="mt-2">
                            <p class="text-sm text-green-700 font-medium mb-1">Files with errors:</p>
                            <ul class="text-xs text-green-600 list-disc list-inside">
                                @foreach(session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Regions</p>
                    <p class="text-2xl font-bold text-gray-900">{{ App\Models\Location::distinct('region_code')->count('region_code') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Districts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ App\Models\Location::distinct('district_code')->count('district_code') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Wards</p>
                    <p class="text-2xl font-bold text-gray-900">{{ App\Models\Location::distinct('ward_code')->count('ward_code') }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Hierarchical Location Browser -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">🗺️ Location Browser</h3>
            <div class="flex items-center space-x-2">
                <button onclick="resetLocationBrowser()" class="px-3 py-1.5 text-sm bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input 
                    type="text" 
                    id="locationSearch" 
                    placeholder="🔍 Search locations (auto-search as you type)..."
                    class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    onkeyup="searchLocations(this.value)"
                >
                <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div id="breadcrumb" class="mb-4 flex items-center space-x-2 text-sm">
            <span class="text-gray-500">🏠</span>
            <span class="text-gray-600">Tanzania</span>
        </div>

        <!-- Location Grid -->
        <div id="locationGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- Regions will be loaded here -->
        </div>
    </div>

    <!-- Import/Export Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">📁 Bulk Operations</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Import -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-3">📥 Import Locations</h4>
                <p class="text-sm text-gray-600 mb-4">Import Tanzania locations from multiple CSV files</p>
                <form method="POST" action="{{ route('locations.import') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CSV Files</label>
                        <input type="file" name="files[]" accept=".csv,.txt" multiple required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        <p class="text-xs text-gray-500 mt-1">Select one or more CSV files (Max 10MB each)</p>
                        <p class="text-xs text-blue-600 mt-1">💡 You can select multiple files by holding Ctrl/Cmd while clicking</p>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Import Locations
                    </button>
                </form>
            </div>

            <!-- Export -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="font-medium text-gray-800 mb-3">📤 Export Locations</h4>
                <p class="text-sm text-gray-600 mb-4">Export all locations to CSV file</p>
                <form method="POST" action="{{ route('locations.export') }}" class="space-y-4">
                    @csrf
                    @method('POST')
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Export All Locations
                    </button>
                </form>
                <div class="mt-3">
                    <a href="{{ asset('templates/tanzania_locations_template.csv') }}" class="block text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        📋 Download Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">🔍 Filters</h3>
        <form method="GET" action="{{ route('locations.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search locations..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Region</label>
                <select name="region" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Regions</option>
                    @foreach(\App\Models\Location::getRegions() as $code => $name)
                        <option value="{{ $code }}" {{ request('region') == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">District</label>
                <select name="district" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Districts</option>
                    @foreach(\App\Models\Location::getDistricts() as $code => $name)
                        <option value="{{ $code }}" {{ request('district') == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Locations Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">📍 Locations List</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">District</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ward</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Street</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Place</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($locations as $location)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $location->region }}</div>
                                <div class="text-xs text-gray-500">{{ $location->region_code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $location->district }}</div>
                                <div class="text-xs text-gray-500">{{ $location->district_code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $location->ward }}</div>
                                <div class="text-xs text-gray-500">{{ $location->ward_code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $location->street ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $location->place ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($location->is_active)
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('locations.show', $location) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('locations.edit', $location) }}" class="text-purple-600 hover:text-purple-900">Edit</a>
                                    <form method="POST" action="{{ route('locations.destroy', $location) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 mb-1">No locations found</p>
                                    <p class="text-sm text-gray-500 mb-4">Get started by importing locations or adding them manually</p>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('locations.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                            Add Location
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($locations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $locations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Location browser state
let currentLevel = 'regions';
let currentRegion = null;
let currentDistrict = null;
let currentWard = null;
let searchTimeout = null;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadRegions();
});

// Load all regions
function loadRegions() {
    fetch('/api/locations/regions')
        .then(response => response.json())
        .then(data => {
            displayLocations(data, 'region');
        })
        .catch(error => {
            console.error('Error loading regions:', error);
        });
}

// Load districts for a region
function loadDistricts(regionCode, regionName) {
    currentRegion = { code: regionCode, name: regionName };
    currentLevel = 'districts';
    
    fetch(`/api/locations/districts/${regionCode}`)
        .then(response => response.json())
        .then(data => {
            displayLocations(data, 'district');
            updateBreadcrumb('region', regionName);
        })
        .catch(error => {
            console.error('Error loading districts:', error);
        });
}

// Load wards for a district
function loadWards(districtCode, districtName) {
    currentDistrict = { code: districtCode, name: districtName };
    currentLevel = 'wards';
    
    fetch(`/api/locations/wards/${districtCode}`)
        .then(response => response.json())
        .then(data => {
            displayLocations(data, 'ward');
            updateBreadcrumb('district', districtName);
        })
        .catch(error => {
            console.error('Error loading wards:', error);
        });
}

// Load streets for a ward
function loadStreets(wardCode, wardName) {
    currentWard = { code: wardCode, name: wardName };
    currentLevel = 'streets';
    
    fetch(`/api/locations/streets/${wardCode}`)
        .then(response => response.json())
        .then(data => {
            displayLocations(data, 'street');
            updateBreadcrumb('ward', wardName);
        })
        .catch(error => {
            console.error('Error loading streets:', error);
        });
}

// Load places for a street
function loadPlaces(streetName) {
    currentLevel = 'places';
    
    fetch(`/api/locations/places/${encodeURIComponent(streetName)}`)
        .then(response => response.json())
        .then(data => {
            displayLocations(data, 'place');
            updateBreadcrumb('street', streetName);
        })
        .catch(error => {
            console.error('Error loading places:', error);
        });
}

// Display locations in grid
function displayLocations(locations, type) {
    const grid = document.getElementById('locationGrid');
    grid.innerHTML = '';
    
    if (locations.length === 0) {
        grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No locations found</div>';
        return;
    }
    
    locations.forEach(location => {
        const card = createLocationCard(location, type);
        grid.appendChild(card);
    });
}

// Create location card element
function createLocationCard(location, type) {
    const card = document.createElement('div');
    card.className = 'bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all cursor-pointer transform hover:scale-105';
    
    const icons = {
        region: '🗺️',
        district: '🏛️',
        ward: '🏘️',
        street: '🛣️',
        place: '📍'
    };
    
    const colors = {
        region: 'bg-gradient-to-br from-green-50 to-green-100 border-green-200 hover:from-green-100 hover:to-green-200',
        district: 'bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200 hover:from-blue-100 hover:to-blue-200',
        ward: 'bg-gradient-to-br from-purple-50 to-purple-100 border-purple-200 hover:from-purple-100 hover:to-purple-200',
        street: 'bg-gradient-to-br from-orange-50 to-orange-100 border-orange-200 hover:from-orange-100 hover:to-orange-200',
        place: 'bg-gradient-to-br from-red-50 to-red-100 border-red-200 hover:from-red-100 hover:to-red-200'
    };
    
    card.className += ' ' + colors[type];
    
    let name = location.name || location.region || location.district || location.ward || location.street || location.place;
    let code = location.region_code || location.district_code || location.ward_code;
    
    card.innerHTML = `
        <div class="flex flex-col items-center text-center space-y-3">
            <div class="w-16 h-16 bg-white/80 rounded-full flex items-center justify-center mb-3">
                <span class="text-3xl">${icons[type]}</span>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 text-lg mb-1">${name}</h4>
                ${code ? `<p class="text-sm text-gray-600 font-mono">${code}</p>` : ''}
                ${location.count ? `<p class="text-xs text-gray-500 mt-2">${location.count} items</p>` : ''}
            </div>
            <div class="w-full flex justify-center mt-3">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </div>
    `;
    
    // Add click handlers based on type
    card.onclick = function() {
        switch(type) {
            case 'region':
                loadDistricts(location.region_code, location.region);
                break;
            case 'district':
                loadWards(location.district_code, location.district);
                break;
            case 'ward':
                loadStreets(location.ward_code, location.ward);
                break;
            case 'street':
                loadPlaces(location.street);
                break;
            case 'place':
                // Final level - show place details
                showPlaceDetails(location);
                break;
        }
    };
    
    return card;
}

// Update breadcrumb navigation
function updateBreadcrumb(level, name) {
    const breadcrumb = document.getElementById('breadcrumb');
    let html = '<span class="text-gray-500">🏠</span><span class="text-gray-600 cursor-pointer hover:text-purple-600" onclick="resetLocationBrowser()">Tanzania</span>';
    
    if (currentRegion) {
        html += ` <span class="text-gray-400">›</span> <span class="text-gray-600 cursor-pointer hover:text-purple-600" onclick="loadDistricts('${currentRegion.code}', '${currentRegion.name}')">${currentRegion.name}</span>`;
    }
    
    if (currentDistrict) {
        html += ` <span class="text-gray-400">›</span> <span class="text-gray-600 cursor-pointer hover:text-purple-600" onclick="loadWards('${currentDistrict.code}', '${currentDistrict.name}')">${currentDistrict.name}</span>`;
    }
    
    if (currentWard) {
        html += ` <span class="text-gray-400">›</span> <span class="text-gray-600 cursor-pointer hover:text-purple-600" onclick="loadStreets('${currentWard.code}', '${currentWard.name}')">${currentWard.name}</span>`;
    }
    
    if (level !== 'region' && level !== 'district' && level !== 'ward' && level !== 'street') {
        html += ` <span class="text-gray-400">›</span> <span class="text-gray-800 font-medium">${name}</span>`;
    }
    
    breadcrumb.innerHTML = html;
}

// Reset browser to regions level
function resetLocationBrowser() {
    currentLevel = 'regions';
    currentRegion = null;
    currentDistrict = null;
    currentWard = null;
    document.getElementById('locationSearch').value = '';
    loadRegions();
    updateBreadcrumb('regions', 'Tanzania');
}

// Search locations with auto-search
function searchLocations(query) {
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        if (currentLevel === 'regions') {
            loadRegions();
        }
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch(`/api/locations/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Error searching locations:', error);
            });
    }, 300); // 300ms delay for auto-search
}

// Display search results
function displaySearchResults(results) {
    const grid = document.getElementById('locationGrid');
    grid.innerHTML = '';
    
    if (results.length === 0) {
        grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No results found</div>';
        return;
    }
    
    results.forEach(result => {
        const card = createSearchResultCard(result);
        grid.appendChild(card);
    });
}

// Create search result card
function createSearchResultCard(result) {
    const card = document.createElement('div');
    card.className = 'bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer hover:bg-yellow-50';
    
    const fullPath = [result.region, result.district, result.ward, result.street, result.place].filter(Boolean).join(' › ');
    
    card.innerHTML = `
        <div class="flex items-start space-x-3">
            <span class="text-2xl">🔍</span>
            <div class="flex-1">
                <h4 class="font-medium text-gray-800">${result.place || result.street || result.ward || result.district || result.region}</h4>
                <p class="text-sm text-gray-500 mt-1">${fullPath}</p>
                <p class="text-xs text-gray-400 mt-2">Click to navigate</p>
            </div>
        </div>
    `;
    
    card.onclick = function() {
        // Navigate to the specific location
        if (result.region_code) {
            loadDistricts(result.region_code, result.region);
            setTimeout(() => {
                if (result.district_code) {
                    loadWards(result.district_code, result.district);
                    setTimeout(() => {
                        if (result.ward_code) {
                            loadStreets(result.ward_code, result.ward);
                            setTimeout(() => {
                                if (result.street) {
                                    loadPlaces(result.street);
                                }
                            }, 100);
                        }
                    }, 100);
                }
            }, 100);
        }
    };
    
    return card;
}

// Show place details (final level)
function showPlaceDetails(place) {
    const grid = document.getElementById('locationGrid');
    grid.innerHTML = `
        <div class="col-span-full bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-center space-x-3 mb-4">
                <span class="text-3xl">📍</span>
                <div>
                    <h3 class="text-lg font-medium text-gray-800">${place.place}</h3>
                    <p class="text-sm text-gray-500">Full Location Details</p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700"><strong>Region:</strong> ${place.region}</p>
                <p class="text-gray-700"><strong>District:</strong> ${place.district}</p>
                <p class="text-gray-700"><strong>Ward:</strong> ${place.ward}</p>
                <p class="text-gray-700"><strong>Street:</strong> ${place.street || 'N/A'}</p>
                <p class="text-gray-700"><strong>Place:</strong> ${place.place}</p>
                <p class="text-gray-700"><strong>Status:</strong> ${place.is_active ? 'Active' : 'Inactive'}</p>
            </div>
        </div>
    `;
}
</script>
@endpush
