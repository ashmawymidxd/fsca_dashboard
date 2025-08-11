@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Service'),
        'description' => __('Update the service information.'),
        'class' => 'col-lg-12',
    ])
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 text-primary">{{ __('Edit Service') }}</h3>
                                <p class="text-sm text-muted mb-0">{{ __('Update the details below') }}</p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('complete_services.index') }}" class="btn btn-sm btn-default">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('complete_services.update', $completeService) }}" 
                              autocomplete="off" enctype="multipart/form-data" id="service-edit-form">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4 pr-lg-4">
                                <!-- Titles Section -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Service Titles') }}</h5>
                                        <p class="text-sm text-muted mb-0">{{ __('Update titles in both languages') }}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group{{ $errors->has('title_en') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title-en">
                                                <i class="fas fa-language mr-1 text-info"></i> {{ __('English Title') }}
                                            </label>
                                            <input type="text" name="title_en" id="input-title-en"
                                                class="form-control form-control-alternative{{ $errors->has('title_en') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('e.g. Web Development') }}"
                                                value="{{ old('title_en', $completeService->title_en) }}" required autofocus>
                                            @if ($errors->has('title_en'))
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title_en') }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('title_ar') ? ' has-danger' : '' }} mt-4">
                                            <label class="form-control-label" for="input-title-ar">
                                                <i class="fas fa-language mr-1 text-info"></i> {{ __('Arabic Title') }}
                                            </label>
                                            <input type="text" name="title_ar" id="input-title-ar" dir="rtl"
                                                class="form-control form-control-alternative{{ $errors->has('title_ar') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('e.g. تطوير الويب') }}"
                                                value="{{ old('title_ar', $completeService->title_ar) }}" required>
                                            @if ($errors->has('title_ar'))
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title_ar') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Section -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Service Image') }}</h5>
                                        <p class="text-sm text-muted mb-0">{{ __('Update or change the cover image') }}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-control-label d-block">
                                                <i class="fas fa-image mr-1 text-info"></i> {{ __('Current Image') }}
                                            </label>
                                            <div class="text-center mb-3">
                                                <img src="{{ asset($completeService->image_path) }}" 
                                                     alt="{{ $completeService->title_en }}" 
                                                     class="img-thumbnail rounded" 
                                                     style="max-height: 250px;">
                                                <p class="text-sm text-muted mt-2">
                                                    {{ __('Current service image') }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label d-block">
                                                <i class="fas fa-upload mr-1 text-info"></i> {{ __('New Image') }}
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" name="image"
                                                    class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                    id="input-image" accept="image/*">
                                                <label class="custom-file-label" for="input-image">
                                                    {{ __('Choose new image...') }}
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Leave blank to keep current image. Recommended: 800×600 pixels. Max size: 2MB.') }}
                                            </small>
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Section -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Visibility Status') }}</h5>
                                        <p class="text-sm text-muted mb-0">{{ __('Control where this service appears') }}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-active" name="status" value="active" 
                                                    class="custom-control-input" 
                                                    {{ old('status', $completeService->status) == 'active' ? 'checked' : '' }} required>
                                                <label class="custom-control-label text-success font-weight-bold" for="status-active">
                                                    <i class="fas fa-eye mr-1"></i> Show on Landing Page
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-inactive" name="status" value="inactive" 
                                                    class="custom-control-input" 
                                                    {{ old('status', $completeService->status) == 'inactive' ? 'checked' : '' }}>
                                                <label class="custom-control-label text-light font-weight-bold" for="status-inactive">
                                                    <i class="fas fa-eye-slash mr-1"></i> Hide from Landing Page
                                                </label>
                                            </div>
                                            <small class="form-text text-muted mt-2">
                                                {{ __('Active services will be visible to all users on the landing page') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-3">
                                        <i class="fas fa-save mr-2"></i> {{ __('Update Service') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        // File input label update
        document.getElementById('input-image').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '{{ __("Choose new image...") }}';
            const label = e.target.nextElementSibling;
            label.innerText = fileName;
            
            // Image preview for new image
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                const preview = document.createElement('div');
                preview.className = 'text-center mt-3';
                preview.innerHTML = `
                    <img id="new-image-preview" src="#" alt="New image preview" class="img-thumbnail rounded" style="max-height: 200px;">
                    <p class="text-sm text-muted mt-2">{{ __('New image preview') }}</p>
                `;
                e.target.closest('.form-group').appendChild(preview);
                
                reader.onload = function(event) {
                    document.getElementById('new-image-preview').src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form validation
        document.getElementById('service-edit-form').addEventListener('submit', function(e) {
            const titleEn = document.getElementById('input-title-en').value.trim();
            const titleAr = document.getElementById('input-title-ar').value.trim();
            
            if (!titleEn || !titleAr) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    </script>
    
    <style>
        .card-profile {
            border: none;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        .card-profile:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }
        .custom-file-label::after {
            content: "Browse";
        }
        .form-control-label {
            font-weight: 600;
            color: #525f7f;
        }
        .custom-radio .custom-control-label::before {
            border: 2px solid #dee2e6;
        }
        .custom-radio .custom-control-input:checked~.custom-control-label::before {
            background-color: #5e72e4;
            border-color: #5e72e4;
        }
    </style>
@endpush