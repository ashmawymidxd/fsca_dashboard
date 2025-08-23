@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Service'),
        'description' => __('Add a new service to your portfolio.'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 text-primary">{{ __('Service Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('complete_services.index') }}" class="btn btn-sm btn-default">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('complete_services.store') }}" autocomplete="off"
                            enctype="multipart/form-data" id="service-form">
                            @csrf

                            <div class="pl-lg-4 pr-lg-4">
                                <!-- Status Card -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Service Status') }}</h5>
                                        <p class="text-sm text-muted mb-0">{{ __('Set the visibility of this service') }}
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-active" name="status" value="active"
                                                    class="custom-control-input"
                                                    {{ old('status', $completeService->status ?? 'active') == 'active' ? 'checked' : '' }}
                                                    required>
                                                <label class="custom-control-label text-success font-weight-bold"
                                                    for="status-active">
                                                    <i class="fas fa-check-circle mr-1"></i> Add To Landing Page
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="status-inactive" name="status" value="inactive"
                                                    class="custom-control-input"
                                                    {{ old('status', $completeService->status ?? '') == 'inactive' ? 'checked' : '' }}>
                                                <label class="custom-control-label text-danger font-weight-bold"
                                                    for="status-inactive">
                                                    <i class="fas fa-times-circle mr-1"></i> Hide From Landing Page
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Titles Card -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Service Titles') }}</h5>
                                        <p class="text-sm text-muted mb-0">
                                            {{ __('Enter titles in both English and Arabic') }}</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group{{ $errors->has('title_en') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-title-en">
                                                <i class="fas fa-language mr-1 text-info"></i> {{ __('English Title') }}
                                            </label>
                                            <input type="text" name="title_en" id="input-title-en"
                                                class="form-control form-control-alternative{{ $errors->has('title_en') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('e.g. Web Development') }}"
                                                value="{{ old('title_en') }}" required>
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
                                                placeholder="{{ __('e.g. تطوير الويب') }}" value="{{ old('title_ar') }}"
                                                required>
                                            @if ($errors->has('title_ar'))
                                                <div class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title_ar') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload Card -->
                                <div class="card card-profile shadow mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">{{ __('Service Image') }}</h5>
                                        <p class="text-sm text-muted mb-0">{{ __('Upload a high-quality cover image') }}
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label d-block">
                                                <i class="fas fa-image mr-1 text-info"></i> {{ __('Cover Image') }}
                                            </label>

                                            <div class="text-center mb-3">
                                                <img id="image-preview"
                                                    src="https://thfvnext.bing.com/th/id/OIP.tYoZDaFuXWkTOUzy5sxUWAHaHa?o=7&cb=thfvnextrm=3&rs=1&pid=ImgDetMain&o=7&rm=3"
                                                    alt="Service preview" class="img-thumbnail" style="max-height: 100px;">
                                            </div>

                                            <div class="custom-file">
                                                <input type="file" name="image"
                                                    class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                    id="input-image" required accept="image/*">
                                                <label class="custom-file-label"
                                                    for="input-image">{{ __('Choose image...') }}</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Recommended: 800×600 pixels (JPG, PNG, GIF). Max size: 2MB.') }}
                                            </small>
                                            @if ($errors->has('image'))
                                                <div class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-3">
                                        <i class="fas fa-save mr-2"></i> {{ __('Save Service') }}
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
            const fileName = e.target.files[0]?.name || '{{ __('Choose image...') }}';
            const label = e.target.nextElementSibling;
            label.innerText = fileName;

            // Image preview
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('image-preview').src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Form validation enhancements
        document.getElementById('service-form').addEventListener('submit', function(e) {
            const titleEn = document.getElementById('input-title-en').value.trim();
            const titleAr = document.getElementById('input-title-ar').value.trim();

            if (!titleEn || !titleAr) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    </script>
@endpush

@push('css')
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

        #image-preview {
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-control-label {
            font-weight: 600;
            color: #525f7f;
        }
    </style>
@endpush
