@extends('layouts.app')

@section('title', 'Upload Gallery Image')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 style="margin: 0; font-weight: 700;"><i class="fas fa-cloud-upload-alt me-2" style="color: var(--primary);"></i>Upload Gallery Image</h4>
    </div>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

@if($errors->any())
<div class="alert alert-danger" style="border-radius: 10px;">
    <ul style="margin: 0; padding-left: 1.25rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card-sistech" style="max-width: 700px;">
    <div class="card-body" style="padding: 2rem;">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control" accept="image/*" required id="imageInput" onchange="previewImage(this, 'preview')">
                <small class="text-muted">JPEG, PNG, JPG, GIF, or WebP. Max 5MB.</small>
                <div id="preview" style="margin-top: 10px; display: none;">
                    <img src="" alt="Preview" style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid var(--border);">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Computer Lab" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. campus, events, labs" required list="categoryList">
                <datalist id="categoryList">
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                <small class="text-muted">Type a category or pick from existing ones.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Optional description">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0" style="max-width: 150px;">
                <small class="text-muted">Lower numbers appear first.</small>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="isActive">Active (visible on public site)</label>
                </div>
            </div>

            <button type="submit" class="btn btn-sistech btn-lg">
                <i class="fas fa-upload me-1"></i> Upload Image
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function previewImage(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
