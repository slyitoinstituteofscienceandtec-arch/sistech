@extends('layouts.app')
@section('title', 'Add Book')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Add Book</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Add a new book to the library</p>
    </div>
    <a href="{{ route('admin.library.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card-sistech" style="max-width: 700px;">
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger" style="border-radius: 10px; font-size: 13px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin.library.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">ISBN</label>
                    <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Publisher</label>
                    <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">Select</option>
                        @foreach(['textbook','reference','fiction','non-fiction','journal','digital','other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Shelf Location</label>
                    <input type="text" name="shelf_location" class="form-control" value="{{ old('shelf_location') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">PDF File</label>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                <small class="text-muted">PDF only, max 10MB</small>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.library.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-sistech">
                    <i class="fas fa-save me-1"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
