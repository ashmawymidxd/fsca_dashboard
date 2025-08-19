@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Category: ') . $category->main_header_en,
        'description' => __('Update category information'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Category Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.categories.show', [$service, $category]) }}"
                                    class="btn btn-sm btn-info" data-toggle="tooltip" title="View this category">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('services.categories.update', [$service, $category]) }}"
                            autocomplete="off" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            @method('put')

                            <!-- Progress Indicator -->
                            <div class="form-progress mb-4">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted form-progress-text">0% Complete</small>
                            </div>

                            <!-- Language Tabs -->
                            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings"
                                        role="tab">
                                        <i class="fas fa-cog mr-1"></i> {{ __('Settings') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="english-tab" data-toggle="tab" href="#english" role="tab">
                                        <i class="fas fa-language mr-1"></i> {{ __('English') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab">
                                        <i class="fas fa-language mr-1"></i> {{ __('Arabic') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab">
                                        <i class="fas fa-image mr-1"></i> {{ __('Media') }}
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-4" id="languageTabsContent">
                                <!-- Settings Tab -->
                                <div class="tab-pane fade show active" id="settings" role="tabpanel">
                                    <div class="pl-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="type">{{ __('Type') }}</label>
                                            <select name="type" id="type"
                                                class="form-control form-control-alternative" required>
                                                <option value="category"
                                                    {{ $category->type == 'category' ? 'selected' : '' }}>
                                                    {{ __('Category') }}</option>
                                                <option value="banner" {{ $category->type == 'banner' ? 'selected' : '' }}>
                                                    {{ __('Banner') }}</option>
                                            </select>
                                            <small
                                                class="form-text text-muted">{{ __('Select whether this is a category or banner') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- English Content Tab -->
                                <div class="tab-pane fade" id="english" role="tabpanel">
                                    <div class="pl-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="main_header_en">{{ __('Main Header') }}</label>
                                            <input type="text" name="main_header_en" id="main_header_en"
                                                class="form-control form-control-alternative"
                                                placeholder="{{ __('Enter main header in English') }}"
                                                value="{{ old('main_header_en', $category->main_header_en) }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="notBanner">
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="sub_header_en">{{ __('Sub Header') }}</label>
                                                <input type="text" name="sub_header_en" id="sub_header_en"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Enter sub header in English') }}"
                                                    value="{{ old('sub_header_en', $category->sub_header_en) }}" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="focus_en">{{ __('Focus Area') }}</label>
                                                <input type="text" name="focus_en" id="focus_en"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Enter focus area in English') }}"
                                                    value="{{ old('focus_en', $category->focus_en) }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-group banner d-none">
                                            <label class="form-control-label" for="button_text_en">
                                                {{ __('Button Text (English)') }}
                                            </label>
                                            <input type="text" name="button_text_en" id="button_text_en"
                                                class="form-control" placeholder="{{ __('e.g. Quality Assurance') }}"
                                                value="{{ old('button_text_en', $category->button_text_en) }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="description_en">{{ __('Description') }}</label>
                                            <textarea name="description_en" id="description_en" class="form-control form-control-alternative" rows="5"
                                                placeholder="{{ __('Enter detailed description in English') }}" required>{{ old('description_en', $category->description_en) }}</textarea>
                                            <div class="invalid-feedback"></div>
                                            <small class="form-text text-muted">{{ __('Minimum 10 characters') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Tab -->
                                <div class="tab-pane fade" id="arabic" role="tabpanel">
                                    <div class="pl-lg-4" dir="rtl" style="text-align: right;">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="main_header_ar">{{ __('Main Header') }}</label>
                                            <input type="text" name="main_header_ar" id="main_header_ar"
                                                class="form-control form-control-alternative"
                                                placeholder="{{ __('Enter main header in Arabic') }}"
                                                value="{{ old('main_header_ar', $category->main_header_ar) }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="notBanner">
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="sub_header_ar">{{ __('Sub Header') }}</label>
                                                <input type="text" name="sub_header_ar" id="sub_header_ar"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Enter sub header in Arabic') }}"
                                                    value="{{ old('sub_header_ar', $category->sub_header_ar) }}" required>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label"
                                                    for="focus_ar">{{ __('Focus Area') }}</label>
                                                <input type="text" name="focus_ar" id="focus_ar"
                                                    class="form-control form-control-alternative"
                                                    placeholder="{{ __('Enter focus area in Arabic') }}"
                                                    value="{{ old('focus_ar', $category->focus_ar) }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-group banner d-none">
                                            <label class="form-control-label" for="button_text_ar">
                                                {{ __('Button Text (عربي)') }}
                                            </label>
                                            <input type="text" name="button_text_ar" id="button_text_ar"
                                                class="form-control text-right" dir="rtl"
                                                placeholder="{{ __('e.g. ضمان الجودة') }}"
                                                value="{{ old('button_text_ar', $category->button_text_ar) }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="description_ar">{{ __('Description') }}</label>
                                            <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative" rows="5"
                                                placeholder="{{ __('Enter detailed description in Arabic') }}" required>{{ old('description_ar', $category->description_ar) }}</textarea>
                                            <div class="invalid-feedback"></div>
                                            <small class="form-text text-muted">{{ __('Minimum 10 characters') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Tab -->
                                <div class="tab-pane fade" id="media" role="tabpanel">
                                    <div class="pl-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="cover_image">{{ __('Cover Image') }}</label>
                                            <div class="custom-file">
                                                <input type="file" name="cover_image" id="cover_image"
                                                    class="custom-file-input" accept="image/*"
                                                    onchange="previewImage(this)">
                                                <label class="custom-file-label"
                                                    for="cover_image">{{ __('Choose new image...') }}</label>
                                            </div>
                                            <small
                                                class="form-text text-muted">{{ __('Recommended size: 1200x630 pixels') }}</small>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="mb-0">{{ __('Current Image') }}</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <img id="imagePreview" src="{{ url($category->cover_image) }}"
                                                    class="img-fluid rounded" style="max-height: 200px;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="removeImage()">
                                                        <i class="fas fa-trash-alt mr-1"></i> {{ __('Remove Image') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="fas fa-save mr-2"></i> {{ __('Update Category') }}
                                </button>
                                <a href="{{ route('services.categories.index', $service) }}"
                                    class="btn btn-secondary px-5">
                                    <i class="fas fa-times mr-2"></i> {{ __('Cancel') }}
                                </a>
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
        // Initialize tabs
        $(document).ready(function() {
            // Initialize based on current type
            toggleFieldsBasedOnType();

            // Handle type change
            $("#type").change(function() {
                toggleFieldsBasedOnType();
                updateFormProgress();
            });

            $('#languageTabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // Form progress tracking
            $('#categoryForm input, #categoryForm textarea, #categoryForm select').on('input change', function() {
                updateFormProgress();
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Toggle fields based on selected type
        function toggleFieldsBasedOnType() {
            const type = $("#type").val();

            if (type === "banner") {
                $(".notBanner").hide();
                $(".banner").removeClass('d-none');

                // Make banner-specific fields NOT required (this is the change)
                $("#button_text_en").prop('required', false);
                $("#button_text_ar").prop('required', false);

                // Make category-specific fields not required
                $("#sub_header_en").prop('required', false);
                $("#sub_header_ar").prop('required', false);
                $("#focus_en").prop('required', false);
                $("#focus_ar").prop('required', false);
            } else {
                $(".notBanner").show();
                $(".banner").addClass('d-none');

                // Make category-specific fields required
                $("#sub_header_en").prop('required', true);
                $("#sub_header_ar").prop('required', true);

                // Make banner-specific fields not required
                $("#button_text_en").prop('required', false);
                $("#button_text_ar").prop('required', false);
            }
        }

        // Update form progress
        function updateFormProgress() {
            const totalFields = $('#categoryForm :input[required]').length;
            let filledFields = 0;

            $('#categoryForm :input[required]').each(function() {
                if ($(this).val() !== '') {
                    filledFields++;
                }
            });

            const progress = Math.round((filledFields / totalFields) * 100);
            $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
            $('.form-progress-text').text(progress + '% Complete');
        }

        // Image preview functionality
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove image functionality
        function removeImage() {
            $('#imagePreview').attr('src', 'https://via.placeholder.com/1200x630?text=No+Image');
            $('#cover_image').val('');
        }

        // Form validation
        $(document).ready(function() {
            $('#categoryForm').on('submit', function(e) {
                let isValid = true;

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                // Validate required fields based on type
                const type = $("#type").val();

                if (type === "banner") {
                    // Banner validation - button text is NOT required
                    $('#categoryForm :input[required]').each(function() {
                        if ($(this).val() === '') {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text('This field is required');
                            isValid = false;
                        }
                    });
                } else {
                    // Category validation
                    $('#categoryForm :input[required]').each(function() {
                        if ($(this).val() === '') {
                            $(this).addClass('is-invalid');
                            $(this).next('.invalid-feedback').text('This field is required');
                            isValid = false;
                        }
                    });
                }

                // Validate text lengths
                if ($('#description_en').val().length < 10) {
                    $('#description_en').addClass('is-invalid');
                    $('#description_en').next('.invalid-feedback').text(
                        'Description must be at least 10 characters');
                    isValid = false;
                }

                if ($('#description_ar').val().length < 10) {
                    $('#description_ar').addClass('is-invalid');
                    $('#description_ar').next('.invalid-feedback').text(
                        'Description must be at least 10 characters');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    // Show first tab with error
                    $('.nav-tabs a[href="#' + $('.is-invalid').first().closest('.tab-pane').attr('id') +
                        '"]').tab('show');
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .form-progress {
            margin-bottom: 20px;
        }

        .progress {
            height: 10px;
            margin-bottom: 5px;
        }

        .custom-file-label::after {
            content: "{{ __('Browse') }}";
        }

        .tab-pane {
            padding: 15px;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            border-radius: 0 0 4px 4px;
        }

        .is-invalid {
            border-color: #fb6340;
        }

        .invalid-feedback {
            display: block;
            color: #fb6340;
        }
    </style>
@endpush
