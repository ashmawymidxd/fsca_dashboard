@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Add New Category to Service: ') . $service->title_en,
        'description' => __('Create a new category or banner for this service'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <!-- Card Header with Progress Steps -->
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="steps-container">
                                    <div class="steps">
                                        <div class="step active" data-step="1">
                                            <div class="step-circle">1</div>
                                            <div class="step-title">{{ __('Basic Info') }}</div>
                                        </div>
                                        <div class="step" data-step="2">
                                            <div class="step-circle">2</div>
                                            <div class="step-title">{{ __('Content') }}</div>
                                        </div>
                                        <div class="step" data-step="3">
                                            <div class="step-circle">3</div>
                                            <div class="step-title">{{ __('Media') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('services.categories.store', $service) }}" autocomplete="off"
                            enctype="multipart/form-data" id="categoryForm">
                            @csrf

                            <!-- Step 1: Basic Information -->
                            <div class="step-content active" data-step="1">
                                <h6 class="heading-small text-muted mb-4">
                                    <i class="ni ni-badge mr-2"></i>{{ __('Basic Information') }}
                                </h6>

                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="type">
                                            {{ __('Type') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <label class="btn btn-outline-primary active">
                                                <input type="radio" name="type" id="type_category" value="category"
                                                    checked>
                                                <i class="ni ni-collection mr-2"></i>{{ __('Category') }}
                                            </label>
                                            <label class="btn btn-outline-primary">
                                                <input type="radio" name="type" id="type_banner" value="banner">
                                                <i class="ni ni-image mr-2"></i>{{ __('Banner') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ __('Categories appear in the main navigation, banners are promotional displays') }}
                                        </small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="main_header_en">
                                                    {{ __('Main Header (English)') }} <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-font"></i></span>
                                                    </div>
                                                    <input type="text" name="main_header_en" id="main_header_en"
                                                        class="form-control" placeholder="{{ __('e.g. Our Services') }}"
                                                        value="{{ old('main_header_en') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="main_header_ar">
                                                    {{ __('Main Header (Arabic)') }} <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-font"></i></span>
                                                    </div>
                                                    <input type="text" name="main_header_ar" id="main_header_ar"
                                                        class="form-control text-right" dir="rtl"
                                                        placeholder="{{ __('e.g. خدماتنا') }}"
                                                        value="{{ old('main_header_ar') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-4">
                                        <button type="button" class="btn btn-primary next-step">
                                            {{ __('Next') }} <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Content Details -->
                            <div class="step-content" data-step="2">
                                <h6 class="heading-small text-muted mb-4">
                                    <i class="ni ni-align-left-2 mr-2"></i>{{ __('Content Details') }}
                                </h6>
                                <div class="pl-lg-4">
                                    <div class="row notBanner">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="sub_header_en">
                                                    {{ __('Sub Header (English)') }}
                                                </label>
                                                <input type="text" name="sub_header_en" id="sub_header_en"
                                                    class="subHeader form-control"
                                                    placeholder="{{ __('e.g. Comprehensive Solutions') }}"
                                                    value="{{ old('sub_header_en') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="sub_header_ar">
                                                    {{ __('Sub Header (Arabic)') }}
                                                </label>
                                                <input type="text" name="sub_header_ar" id="sub_header_ar"
                                                    class="subHeader form-control text-right" dir="rtl"
                                                    placeholder="{{ __('e.g. حلول شاملة') }}"
                                                    value="{{ old('sub_header_ar') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row notBanner">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="focus_en">
                                                    {{ __('Focus Text (English)') }}
                                                </label>
                                                <input type="text" name="focus_en" id="focus_en"
                                                    class="form-control" placeholder="{{ __('e.g. Quality Assurance') }}"
                                                    value="{{ old('focus_en') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="focus_ar">
                                                    {{ __('Focus Text (Arabic)') }}
                                                </label>
                                                <input type="text" name="focus_ar" id="focus_ar"
                                                    class="form-control text-right" dir="rtl"
                                                    placeholder="{{ __('e.g. ضمان الجودة') }}"
                                                    value="{{ old('focus_ar') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row banner d-none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="button_text_en">
                                                    {{ __('Button Text (English)') }}
                                                </label>
                                                <input type="text" name="button_text_en" id="button_text_en"
                                                    class="form-control" placeholder="{{ __('e.g. Quality Assurance') }}"
                                                    value="{{ old('button_text_en') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="button_text_ar">
                                                    {{ __('Button Text (Arabic)') }}
                                                </label>
                                                <input type="text" name="button_text_ar" id="button_text_ar"
                                                    class="form-control text-right" dir="rtl"
                                                    placeholder="{{ __('e.g. ضمان الجودة') }}"
                                                    value="{{ old('button_text_ar') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="description_en">
                                                    {{ __('Description (English)') }} <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="description_en" id="description_en" class="form-control" rows="4"
                                                    placeholder="{{ __('Detailed description in English') }}" required>{{ old('description_en') }}</textarea>
                                                <small
                                                    class="form-text text-muted">{{ __('Minimum 10 characters') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="description_ar">
                                                    {{ __('Description (Arabic)') }} <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="description_ar" id="description_ar" class="form-control text-right" dir="rtl" rows="4"
                                                    placeholder="{{ __('Detailed description in Arabic') }}" required>{{ old('description_ar') }}</textarea>
                                                <small
                                                    class="form-text text-muted">{{ __('Minimum 10 characters') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-step">
                                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back') }}
                                        </button>
                                        <button type="button" class="btn btn-primary next-step">
                                            {{ __('Next') }} <i class="fas fa-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Media Upload -->
                            <div class="step-content" data-step="3">
                                <h6 class="heading-small text-muted mb-4">
                                    <i class="ni ni-image mr-2"></i>{{ __('Media Upload') }}
                                </h6>

                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="cover_image">
                                            {{ __('Cover Image') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" id="cover_image"
                                                class="custom-file-input" accept="image/*" required>
                                            <label class="custom-file-label"
                                                for="cover_image">{{ __('Choose image file') }}</label>
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ __('Recommended size: 1200×400 pixels for banners, 800×600 for categories') }}
                                        </small>
                                    </div>

                                    <div class="image-preview-container text-center mt-4">
                                        <img id="imagePreview" src="#" alt="Image Preview"
                                            class="img-fluid rounded" style="display: none; max-height: 300px;">
                                        <div id="noImagePreview" class="p-4 border rounded bg-light">
                                            <i class="ni ni-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">{{ __('Image preview will appear here') }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-secondary prev-step">
                                            <i class="fas fa-arrow-left mr-2"></i>{{ __('Back') }}
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>{{ __('Save Category') }}
                                        </button>
                                    </div>
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
            $("#type_banner").change(function() {
                $(".notBanner").hide();
                $(".banner").removeClass('d-none');
            })
            // Multi-step form navigation
            $('.next-step').click(function() {
                const currentStep = $(this).closest('.step-content').data('step');
                const nextStep = currentStep + 1;

                if (validateStep(currentStep)) {
                    $(`[data-step="${currentStep}"]`).removeClass('active');
                    $(`[data-step="${nextStep}"]`).addClass('active');

                    // Update progress indicator
                    $(`.step[data-step="${currentStep}"]`).removeClass('active').addClass('completed');
                    $(`.step[data-step="${nextStep}"]`).addClass('active');
                }
            });

            $('.prev-step').click(function() {
                const currentStep = $(this).closest('.step-content').data('step');
                const prevStep = currentStep - 1;

                $(`[data-step="${currentStep}"]`).removeClass('active');
                $(`[data-step="${prevStep}"]`).addClass('active');

                // Update progress indicator
                $(`.step[data-step="${currentStep}"]`).removeClass('active');
                $(`.step[data-step="${prevStep}"]`).addClass('active').removeClass('completed');
            });

            // Form validation for each step
            function validateStep(step) {
                let isValid = true;

                if (step === 1) {
                    if ($('#main_header_en').val().trim() === '') {
                        showError($('#main_header_en'), '{{ __('English header is required') }}');
                        isValid = false;
                    }
                    if ($('#main_header_ar').val().trim() === '') {
                        showError($('#main_header_ar'), '{{ __('Arabic header is required') }}');
                        isValid = false;
                    }
                } else if (step === 2) {
                    if ($('#description_en').val().trim().length < 10) {
                        showError($('#description_en'), '{{ __('Description must be at least 10 characters') }}');
                        isValid = false;
                    }
                    if ($('#description_ar').val().trim().length < 10) {
                        showError($('#description_ar'), '{{ __('Description must be at least 10 characters') }}');
                        isValid = false;
                    }
                }

                return isValid;
            }

            function showError(element, message) {
                const formGroup = element.closest('.form-group');
                formGroup.addClass('has-danger');

                let errorElement = formGroup.find('.invalid-feedback');
                if (errorElement.length === 0) {
                    errorElement = $(`<div class="invalid-feedback">${message}</div>`);
                    formGroup.append(errorElement);
                } else {
                    errorElement.text(message);
                }

                // Scroll to the first error
                $('html, body').animate({
                    scrollTop: formGroup.offset().top - 100
                }, 500);
            }

            // Image preview
            $('#cover_image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                        $('#noImagePreview').hide();
                    }

                    reader.readAsDataURL(file);
                    $('.custom-file-label').text(file.name);
                }
            });

            // Custom file input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endpush

@push('css')
    <style>
        /* Step progress indicator */
        .steps-container {
            padding: 20px 0;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #adb5bd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            border: 3px solid #fff;
        }

        .step.active .step-circle {
            background: #5e72e4;
            color: white;
        }

        .step.completed .step-circle {
            background: #2dce89;
            color: white;
        }

        .step-title {
            font-size: 0.875rem;
            color: #adb5bd;
            font-weight: 500;
        }

        .step.active .step-title {
            color: #5e72e4;
            font-weight: 600;
        }

        .step.completed .step-title {
            color: #2dce89;
        }

        /* Step content */
        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form enhancements */
        .form-control-label {
            font-weight: 600;
            color: #525f7f;
        }

        .has-danger .form-control {
            border-color: #f5365c;
        }

        .has-danger .invalid-feedback {
            display: block;
            color: #f5365c;
        }

        /* RTL support for Arabic fields */
        .text-right[dir="rtl"] {
            text-align: right;
        }

        /* Custom file input */
        .custom-file-label::after {
            content: "{{ __('Browse') }}";
        }

        /* Button transitions */
        .btn {
            transition: all 0.15s ease;
        }
    </style>
@endpush
