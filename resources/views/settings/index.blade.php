@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Settings</h4>
        <p class="text-muted mb-0" style="font-size:13px;">Manage institution settings and preferences</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card-sistech mb-3">
                <div class="card-header">
                    <i class="fas fa-university me-2" style="color: var(--primary);"></i>Institution Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Institution Name</label>
                        <input type="text" name="institution_name" class="form-control" value="{{ old('institution_name', $settings['institution_name'] ?? '') }}" placeholder="e.g. SISTECH College">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Motto</label>
                        <input type="text" name="institution_motto" class="form-control" value="{{ old('institution_motto', $settings['institution_motto'] ?? '') }}" placeholder="e.g. Connecting People to Technology">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="institution_address" class="form-control" rows="2" placeholder="Full institution address">{{ old('institution_address', $settings['institution_address'] ?? '') }}</textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="institution_phone" class="form-control" value="{{ old('institution_phone', $settings['institution_phone'] ?? '') }}" placeholder="+232 77 893 327">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone 2</label>
                            <input type="text" name="institution_phone2" class="form-control" value="{{ old('institution_phone2', $settings['institution_phone2'] ?? '') }}" placeholder="+232 34 145 006">
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="institution_email" class="form-control" value="{{ old('institution_email', $settings['institution_email'] ?? '') }}" placeholder="sistech2025@gmail.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Website</label>
                            <input type="url" name="institution_website" class="form-control" value="{{ old('institution_website', $settings['institution_website'] ?? '') }}" placeholder="https://sistech.website">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-sistech mb-3">
                <div class="card-header">
                    <i class="fas fa-share-alt me-2" style="color: var(--green);"></i>Social Media
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Facebook URL</label>
                        <input type="url" name="institution_facebook" class="form-control" value="{{ old('institution_facebook', $settings['institution_facebook'] ?? '') }}" placeholder="https://www.facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Twitter / X URL</label>
                        <input type="url" name="institution_twitter" class="form-control" value="{{ old('institution_twitter', $settings['institution_twitter'] ?? '') }}" placeholder="https://x.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Instagram URL</label>
                        <input type="url" name="institution_instagram" class="form-control" value="{{ old('institution_instagram', $settings['institution_instagram'] ?? '') }}" placeholder="https://www.instagram.com/...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">LinkedIn URL</label>
                        <input type="url" name="institution_linkedin" class="form-control" value="{{ old('institution_linkedin', $settings['institution_linkedin'] ?? '') }}" placeholder="https://www.linkedin.com/company/...">
                    </div>
                </div>
            </div>

            <div class="card-sistech">
                <div class="card-header">
                    <i class="fas fa-palette me-2" style="color: #7C3AED;"></i>Branding
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Primary Color</label>
                            <div class="input-group">
                                <input type="color" name="primary_color" class="form-control form-control-color" value="{{ old('primary_color', $settings['primary_color'] ?? '#0066CC') }}">
                                <input type="text" class="form-control" value="{{ old('primary_color', $settings['primary_color'] ?? '#0066CC') }}" id="primaryColorText" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Secondary Color</label>
                            <div class="input-group">
                                <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#00B050') }}">
                                <input type="text" class="form-control" value="{{ old('secondary_color', $settings['secondary_color'] ?? '#00B050') }}" id="secondaryColorText" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-sistech mb-3">
                <div class="card-header">
                    <i class="fas fa-eye me-2" style="color: var(--primary);"></i>Preview
                </div>
                <div class="card-body text-center">
                    <div class="rounded d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden;">
                        <img src="{{ asset('images/badge.png') }}" alt="SISTECH Badge" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h6 class="fw-bold mb-0" id="previewName">{{ $settings['institution_name'] ?? 'SISTECH' }}</h6>
                    <small class="text-muted" id="previewMotto">{{ $settings['institution_motto'] ?? 'Connecting People to Technology' }}</small>
                </div>
            </div>

            <div class="card-sistech">
                <div class="card-body">
                    <button type="submit" class="btn btn-sistech w-100 mb-2">
                        <i class="fas fa-save me-1"></i> Save Settings
                    </button>
                    <small class="text-muted d-block text-center">Changes take effect immediately</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.querySelector('input[name="primary_color"]')?.addEventListener('input', function() {
    document.getElementById('primaryColorText').value = this.value;
    document.getElementById('previewLogo').style.background = this.value;
});

document.querySelector('input[name="secondary_color"]')?.addEventListener('input', function() {
    document.getElementById('secondaryColorText').value = this.value;
});

document.querySelector('input[name="institution_name"]')?.addEventListener('input', function() {
    document.getElementById('previewName').textContent = this.value || 'SISTECH';
});

document.querySelector('input[name="institution_motto"]')?.addEventListener('input', function() {
    document.getElementById('previewMotto').textContent = this.value || 'Connecting People to Technology';
});
</script>
@endsection
