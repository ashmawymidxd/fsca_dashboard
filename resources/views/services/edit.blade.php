@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Service'),
        'description' => __('Update service information'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Service Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('services.update', $service) }}" autocomplete="off"
                            enctype="multipart/form-data" id="service-form">
                            @csrf
                            @method('put')

                            <div class="pl-lg-4">
                                <!-- Language Tabs -->
                                <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english"
                                            role="tab" aria-controls="english" aria-selected="true">
                                            <i class="fas fa-language mr-1"></i> English
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab"
                                            aria-controls="arabic" aria-selected="false">
                                            <i class="fas fa-language mr-1"></i> العربية
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="langTabsContent">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade show active" id="english" role="tabpanel"
                                        aria-labelledby="english-tab">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_en">{{ __('Title (English)') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_en" id="title_en"
                                                class="form-control form-control-alternative"
                                                placeholder="{{ __('Service title in English') }}"
                                                value="{{ old('title_en', $service->title_en) }}" required autofocus>
                                            <small class="form-text text-muted">Keep it concise but descriptive</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="description_en">{{ __('Description (English)') }} <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="description_en" id="description_en" class="form-control form-control-alternative" rows="5"
                                                placeholder="{{ __('Detailed description in English') }}" required>{{ old('description_en', $service->description_en) }}</textarea>
                                            <small class="form-text text-muted">Describe the service in detail (200-500
                                                characters)</small>
                                            <div class="text-right">
                                                <span id="description_en_counter"
                                                    class="badge badge-pill badge-{{ strlen(old('description_en', $service->description_en)) < 200 || strlen(old('description_en', $service->description_en)) > 500 ? 'danger' : 'success' }}">
                                                    {{ strlen(old('description_en', $service->description_en)) }}
                                                    characters
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Arabic Tab -->
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_ar">{{ __('Title (Arabic)') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_ar" id="title_ar"
                                                class="form-control form-control-alternative text-right" dir="rtl"
                                                placeholder="{{ __('Service title in Arabic') }}"
                                                value="{{ old('title_ar', $service->title_ar) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="description_ar">{{ __('Description (Arabic)') }} <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative text-right"
                                                dir="rtl" rows="5" placeholder="{{ __('Detailed description in Arabic') }}" required>{{ old('description_ar', $service->description_ar) }}</textarea>
                                            <div class="text-right">
                                                <span id="description_ar_counter"
                                                    class="badge badge-pill badge-{{ strlen(old('description_ar', $service->description_ar)) < 200 || strlen(old('description_ar', $service->description_ar)) > 500 ? 'danger' : 'success' }}">
                                                    {{ strlen(old('description_ar', $service->description_ar)) }} حروف
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload Section -->
                                <div class="form-group">
                                    <label class="form-control-label" for="cover_image">{{ __('Cover Image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" id="cover_image"
                                            class="custom-file-input" accept="image/*">
                                        <label class="custom-file-label"
                                            for="cover_image">{{ __('Choose new image...') }}</label>
                                    </div>
                                    <small
                                        class="form-text text-muted">{{ __('Recommended size: 1200x630px (leave empty to keep current image)') }}</small>

                                    <!-- Image Preview -->
                                    <div class="mt-3 text-center">
                                        <div class="image-preview-container">
                                            <img id="image-preview" src="{{ url($service->cover_image) }}"
                                                class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="remove-image" style="display: none;">
                                                    <i class="fas fa-trash mr-1"></i> Remove Image
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-primary px-5 py-2">
                                        <i class="fas fa-save mr-2"></i> {{ __('Update Service') }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary px-5 py-2">
                                        <i class="fas fa-undo mr-2"></i> {{ __('Reset') }}
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
        $(document).ready(function() {
            // Character counters
            $('#description_en').on('input', function() {
                const length = $(this).val().length;
                $('#description_en_counter').text(length + ' characters');
                $('#description_en_counter').removeClass('badge-danger badge-success')
                    .addClass(length < 200 || length > 500 ? 'badge-danger' : 'badge-success');
            });

            $('#description_ar').on('input', function() {
                const length = $(this).val().length;
                $('#description_ar_counter').text(length + ' حروف');
                $('#description_ar_counter').removeClass('badge-danger badge-success')
                    .addClass(length < 200 || length > 500 ? 'badge-danger' : 'badge-success');
            });

            // Image preview and removal
            $('#cover_image').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#image-preview').attr('src', event.target.result);
                        $('#remove-image').show();
                    }
                    reader.readAsDataURL(file);
                    $('.custom-file-label').text(file.name);
                }
            });

            $('#remove-image').click(function() {
                $('#cover_image').val('');
                $('.custom-file-label').text('{{ __('Choose new image...') }}');
                $('#image-preview').attr('src', '{{ url($service->cover_image) }}');
                $(this).hide();
            });

            // Form validation
            $('#service-form').submit(function() {
                // Add any additional validation here
                return true;
            });

            // Show active tab on page refresh
            if (location.hash) {
                $('a[href="' + location.hash + '"]').tab('show');
            }

            // Change hash for page-reload
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .nav-tabs .nav-link {
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: #525f7f;
            border: none;
            border-bottom: 3px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: #5e72e4;
            border-bottom: 3px solid #5e72e4;
            background-color: transparent;
        }

        .nav-tabs .nav-link:hover:not(.active) {
            border-bottom: 3px solid #dee2e6;
        }

        .tab-content {
            padding: 1.5rem 0;
        }

        .image-preview-container {
            position: relative;
            display: inline-block;
        }

        .custom-file-label::after {
            content: "{{ __('Browse') }}";
        }

        .form-control-alternative.text-right {
            direction: rtl;
        }

        #description_en_counter,
        #description_ar_counter {
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
    </style>
@endpush
