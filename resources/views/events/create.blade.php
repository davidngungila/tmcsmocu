@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Create New Event</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Add a new church event</p>
        </div>
        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
            ← Back
        </a>
    </div>
    
    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Basic Information</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Event Type *</label>
                        <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select Type</option>
                            <optgroup label="Catholic Masses">
                                <option value="misa_ya_kawaida" {{ old('type') === 'misa_ya_kawaida' ? 'selected' : '' }}>Regular Mass</option>
                                <option value="misa_maalum" {{ old('type') === 'misa_maalum' ? 'selected' : '' }}>Special Mass (Wedding, Funeral, Confirmation)</option>
                                <option value="harusi" {{ old('type') === 'harusi' ? 'selected' : '' }}>Wedding Mass</option>
                                <option value="mazishi" {{ old('type') === 'mazishi' ? 'selected' : '' }}>Funeral Mass</option>
                                <option value="kipaimara" {{ old('type') === 'kipaimara' ? 'selected' : '' }}>Confirmation Mass</option>
                            </optgroup>
                            <optgroup label="Catholic Devotions">
                                <option value="novena" {{ old('type') === 'novena' ? 'selected' : '' }}>Novena</option>
                                <option value="adoration" {{ old('type') === 'adoration' ? 'selected' : '' }}>Adoration</option>
                                <option value="ekaristi_takatifu" {{ old('type') === 'ekaristi_takatifu' ? 'selected' : '' }}>Holy Eucharist</option>
                            </optgroup>
                            <optgroup label="Liturgical Seasons">
                                <option value="kwaresima" {{ old('type') === 'kwaresima' ? 'selected' : '' }}>Lent</option>
                                <option value="kipindi_cha_pasaka" {{ old('type') === 'kipindi_cha_pasaka' ? 'selected' : '' }}>Easter Season</option>
                            </optgroup>
                            <optgroup label="Meetings & Events">
                                <option value="mikutano_ya_jumuiya" {{ old('type') === 'mikutano_ya_jumuiya' ? 'selected' : '' }}>Community Meetings</option>
                                <option value="semina" {{ old('type') === 'semina' ? 'selected' : '' }}>Seminar</option>
                                <option value="retreata" {{ old('type') === 'retreata' ? 'selected' : '' }}>Retreat</option>
                                <option value="matukio_ya_dayosisi" {{ old('type') === 'matukio_ya_dayosisi' ? 'selected' : '' }}>Diocese Events</option>
                            </optgroup>
                            <optgroup label="Other">
                                <option value="ibada" {{ old('type') === 'ibada' ? 'selected' : '' }}>Worship Service</option>
                                <option value="mkesha" {{ old('type') === 'mkesha' ? 'selected' : '' }}>Overnight Service</option>
                                <option value="mkutano_wa_vijana" {{ old('type') === 'mkutano_wa_vijana' ? 'selected' : '' }}>Youth Meeting</option>
                                <option value="charity" {{ old('type') === 'charity' ? 'selected' : '' }}>Charity</option>
                                <option value="hija" {{ old('type') === 'hija' ? 'selected' : '' }}>Pilgrimage</option>
                            </optgroup>
                        </select>
                        @error('type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Category *</label>
                        <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="misa_ya_kawaida" {{ old('category', 'misa_ya_kawaida') === 'misa_ya_kawaida' ? 'selected' : '' }}>Regular Mass</option>
                            <option value="misa_maalum" {{ old('category') === 'misa_maalum' ? 'selected' : '' }}>Special Mass</option>
                            <option value="harusi" {{ old('category') === 'harusi' ? 'selected' : '' }}>Wedding</option>
                            <option value="mazishi" {{ old('category') === 'mazishi' ? 'selected' : '' }}>Funeral</option>
                            <option value="kipaimara" {{ old('category') === 'kipaimara' ? 'selected' : '' }}>Confirmation</option>
                            <option value="novena" {{ old('category') === 'novena' ? 'selected' : '' }}>Novena</option>
                            <option value="adoration" {{ old('category') === 'adoration' ? 'selected' : '' }}>Adoration</option>
                            <option value="ekaristi_takatifu" {{ old('category') === 'ekaristi_takatifu' ? 'selected' : '' }}>Holy Eucharist</option>
                            <option value="kwaresima" {{ old('category') === 'kwaresima' ? 'selected' : '' }}>Lent</option>
                            <option value="kipindi_cha_pasaka" {{ old('category') === 'kipindi_cha_pasaka' ? 'selected' : '' }}>Easter Season</option>
                            <option value="mikutano_ya_jumuiya" {{ old('category') === 'mikutano_ya_jumuiya' ? 'selected' : '' }}>Community Meetings</option>
                            <option value="semina" {{ old('category') === 'semina' ? 'selected' : '' }}>Seminar</option>
                            <option value="retreata" {{ old('category') === 'retreata' ? 'selected' : '' }}>Retreat</option>
                            <option value="matukio_ya_dayosisi" {{ old('category') === 'matukio_ya_dayosisi' ? 'selected' : '' }}>Diocese Events</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Event Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Event Theme</label>
                    <input type="text" name="theme" value="{{ old('theme') }}" placeholder="e.g., 'Awakening of Faith'"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Spiritual Theme / Scripture Quote</label>
                    <textarea name="spiritual_theme" rows="3" placeholder="Enter spiritual theme or scripture quote..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('spiritual_theme') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Scripture Readings</label>
                    <textarea name="scripture_readings" rows="3" placeholder="Enter scripture readings for the event..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('scripture_readings') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Date & Location -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Date & Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Parish</label>
                    <input type="text" name="parish" value="{{ old('parish') }}" placeholder="Parish name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Priest / Bishop Name</label>
                    <input type="text" name="priest_name" value="{{ old('priest_name') }}" placeholder="Name of presiding priest/bishop"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Liturgical Color</label>
                    <select name="liturgical_color" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Select Color</option>
                        <option value="white" {{ old('liturgical_color') === 'white' ? 'selected' : '' }}>White</option>
                        <option value="red" {{ old('liturgical_color') === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="green" {{ old('liturgical_color') === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="purple" {{ old('liturgical_color') === 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="rose" {{ old('liturgical_color') === 'rose' ? 'selected' : '' }}>Rose</option>
                        <option value="black" {{ old('liturgical_color') === 'black' ? 'selected' : '' }}>Black</option>
                        <option value="gold" {{ old('liturgical_color') === 'gold' ? 'selected' : '' }}>Gold</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Community</label>
                    <input type="text" name="community" value="{{ old('community') }}" placeholder="Community involved"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Expected Attendance</label>
                    <input type="number" name="expected_attendance" value="{{ old('expected_attendance') }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Program & Budget -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Program & Budget</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Program Flow</label>
                    <textarea name="program_flow" rows="6" placeholder="Enter program schedule..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('program_flow') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Budget (TSh)</label>
                    <input type="number" name="budget" value="{{ old('budget') }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <!-- Registration Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Registration Settings</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="registration_required" id="registration_required" value="1" {{ old('registration_required') ? 'checked' : '' }}
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="registration_required" class="ml-2 block text-sm text-gray-700">
                        Registration Required
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="requires_approval" id="requires_approval" value="1" {{ old('requires_approval') ? 'checked' : '' }}
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="requires_approval" class="ml-2 block text-sm text-gray-700">
                        Requires Approval (Church Authority)
                    </label>
                </div>
                
                <div id="approval_fields" style="display: none;">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Approval Level</label>
                        <select name="approval_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="parish_coordinator" {{ old('approval_level') === 'parish_coordinator' ? 'selected' : '' }}>Parish Coordinator</option>
                            <option value="pastor" {{ old('approval_level') === 'pastor' ? 'selected' : '' }}>Pastor</option>
                            <option value="diocese" {{ old('approval_level') === 'diocese' ? 'selected' : '' }}>Diocese</option>
                        </select>
                    </div>
                </div>
                
                <div id="registration_fields" style="display: none;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Registration Deadline</label>
                            <input type="datetime-local" name="registration_deadline" value="{{ old('registration_deadline') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Max Participants</label>
                            <input type="number" name="max_participants" value="{{ old('max_participants') }}" min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status & Communication -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Status & Communication</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="planned" {{ old('status', 'planned') === 'planned' ? 'selected' : '' }}>Planned</option>
                        <option value="registration_open" {{ old('status') === 'registration_open' ? 'selected' : '' }}>Registration Open</option>
                        <option value="ongoing" {{ old('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="send_reminders" id="send_reminders" value="1" {{ old('send_reminders', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <label for="send_reminders" class="ml-2 block text-sm text-gray-700">
                        Send SMS Reminders
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Announcement</label>
                    <textarea name="announcement" rows="3" placeholder="Enter event announcement..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('announcement') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Cover Image</label>
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4">
            <a href="{{ route('events.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                Save Event
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('registration_required').addEventListener('change', function() {
    document.getElementById('registration_fields').style.display = this.checked ? 'block' : 'none';
});
if (document.getElementById('registration_required').checked) {
    document.getElementById('registration_fields').style.display = 'block';
}

document.getElementById('requires_approval').addEventListener('change', function() {
    document.getElementById('approval_fields').style.display = this.checked ? 'block' : 'none';
});
if (document.getElementById('requires_approval').checked) {
    document.getElementById('approval_fields').style.display = 'block';
}
</script>
@endsection
