@extends('layouts.app')

@section('title', 'Create Community')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Create Community</h1>
            <p class="text-muted mb-0">Add a new spiritual community based on academic programme</p>
        </div>
        <div>
            <a href="{{ route('communities.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Communities
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('communities.store') }}">
                @csrf
                
                <!-- Basic Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Community Name *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required placeholder="e.g., BAPSM, BBICT, BHRM">
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="academic_programme" class="form-label">Academic Programme *</label>
                            <input type="text" class="form-control" id="academic_programme" name="academic_programme" 
                                   value="{{ old('academic_programme') }}" required placeholder="e.g., Bachelor of Arts in Political Science and Management">
                            @error('academic_programme')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            <small class="form-text text-muted">Optional: Brief description of the community</small>
                        </div>
                    </div>
                </div>

                <!-- Leadership Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-users me-2"></i>Leadership Information</h5>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="mb-3 text-primary">Chairperson</h6>
                        <div class="mb-3">
                            <label for="chairperson_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="chairperson_name" name="chairperson_name" 
                                   value="{{ old('chairperson_name') }}" placeholder="Chairperson's full name">
                        </div>
                        <div class="mb-3">
                            <label for="chairperson_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="chairperson_email" name="chairperson_email" 
                                   value="{{ old('chairperson_email') }}" placeholder="chairperson@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="chairperson_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="chairperson_phone" name="chairperson_phone" 
                                   value="{{ old('chairperson_phone') }}" placeholder="+255 123 456 789">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="mb-3 text-success">Secretary</h6>
                        <div class="mb-3">
                            <label for="secretary_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="secretary_name" name="secretary_name" 
                                   value="{{ old('secretary_name') }}" placeholder="Secretary's full name">
                        </div>
                        <div class="mb-3">
                            <label for="secretary_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="secretary_email" name="secretary_email" 
                                   value="{{ old('secretary_email') }}" placeholder="secretary@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="secretary_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="secretary_phone" name="secretary_phone" 
                                   value="{{ old('secretary_phone') }}" placeholder="+255 123 456 789">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="mb-3 text-warning">Treasurer</h6>
                        <div class="mb-3">
                            <label for="treasurer_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="treasurer_name" name="treasurer_name" 
                                   value="{{ old('treasurer_name') }}" placeholder="Treasurer's full name">
                        </div>
                        <div class="mb-3">
                            <label for="treasurer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="treasurer_email" name="treasurer_email" 
                                   value="{{ old('treasurer_email') }}" placeholder="treasurer@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="treasurer_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="treasurer_phone" name="treasurer_phone" 
                                   value="{{ old('treasurer_phone') }}" placeholder="+255 123 456 789">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-cog me-2"></i>Settings</h5>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <strong>Active</strong> - Enable this community for member registration
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('communities.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Community
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
                <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Leader</label>
                <select name="leader_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Select Leader</option>
                    @foreach($parishioners as $parishioner)
                    <option value="{{ $parishioner->id }}" {{ old('leader_id') == $parishioner->id ? 'selected' : '' }}>
                        {{ $parishioner->full_name }}
                    </option>
                    @endforeach
                </select>
                @error('leader_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="border-t border-gray-200 pt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('communities.index') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-bold">
                    Create Community
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

