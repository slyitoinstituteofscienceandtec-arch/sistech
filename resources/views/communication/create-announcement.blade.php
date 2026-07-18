@extends('layouts.app')
@section('title', 'Create Announcement')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Create Announcement</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Publish a new announcement</p>
    </div>
    <a href="{{ route('admin.communication.announcements') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-bullhorn me-2" style="color: var(--primary);"></i>Announcement Details
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('admin.communication.announcements.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Announcement title" required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="">Select type...</option>
                                <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>General</option>
                                <option value="academic" {{ old('type') === 'academic' ? 'selected' : '' }}>Academic</option>
                                <option value="finance" {{ old('type') === 'finance' ? 'selected' : '' }}>Finance</option>
                                <option value="events" {{ old('type') === 'events' ? 'selected' : '' }}>Events</option>
                                <option value="urgent" {{ old('type') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Audience <span class="text-danger">*</span></label>
                            <select name="audience" class="form-select" required>
                                <option value="">Select audience...</option>
                                <option value="all" {{ old('audience') === 'all' ? 'selected' : '' }}>All</option>
                                <option value="students" {{ old('audience') === 'students' ? 'selected' : '' }}>Students</option>
                                <option value="staff" {{ old('audience') === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="lecturers" {{ old('audience') === 'lecturers' ? 'selected' : '' }}>Lecturers</option>
                                <option value="parents" {{ old('audience') === 'parents' ? 'selected' : '' }}>Parents</option>
                            </select>
                            @error('audience')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="8" placeholder="Write your announcement content here..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="isPublished" {{ old('is_published', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="isPublished">Publish immediately</label>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.communication.announcements') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-sistech">
                                <i class="fas fa-paper-plane me-1"></i> Publish
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-sistech">
            <div class="card-header">
                <i class="fas fa-info-circle me-2" style="color: var(--primary);"></i>Announcement Tips
            </div>
            <div class="card-body" style="font-size: 13px;">
                <ul class="mb-0" style="padding-left: 16px;">
                    <li class="mb-2">Use a clear, descriptive title</li>
                    <li class="mb-2">Choose the right type for easy filtering</li>
                    <li class="mb-2">Select the appropriate audience for targeted communication</li>
                    <li class="mb-0">You can save as draft by unchecking "Publish immediately"</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
