@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Support & Help Item'),
        'description' => __('Add new help articles, FAQs or support documentation for your users.'),
        'class' => 'col-lg-12',
        'breadcrumbs' => [
            ['url' => route('support-and-helps.index'), 'name' => __('Support & Help')],
            ['name' => __('Create New')]
        ]
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <!-- Card Header with Status Indicator -->
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ __('Support Item Details') }}</h3>
                            <span class="badge badge-pill badge-info">{{ __('New Item') }}</span>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('support-and-helps.store') }}" enctype="multipart/form-data" id="supportItemForm">
                            @csrf

                            <div class="pl-lg-4 pr-lg-4">
                                <!-- Cover Image with Enhanced Upload -->
                                <div class="form-group">
                                    <label class="form-control-label d-block" for="cover_image">
                                        {{ __('Cover Image') }}
                                        <small class="text-muted">{{ __('(Recommended: 800×600px, Max 2MB)') }}</small>
                                    </label>
                                    <div class="image-upload-wrapper">
                                        <div class="image-preview-container text-center mb-3" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Cover preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; display: none;">
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn" style="display: none;">
                                                    <i class="fas fa-trash mr-1"></i> {{ __('Remove') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" id="cover_image" class="custom-file-input"
                                                   accept="image/*" required
                                                   onchange="validateImageSize(this, 2)">
                                            <label class="custom-file-label" for="cover_image" data-browse="{{ __('Browse') }}">
                                                {{ __('Choose file...') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ __('This image will appear as the thumbnail for your support item.') }}
                                        </small>
                                        <div class="invalid-feedback" id="imageError"></div>
                                    </div>
                                </div>

                                <!-- Status Toggle with Better UX -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                        <label class="custom-control-label" for="is_active">
                                            <span class="font-weight-600">{{ __('Publish Now') }}</span>
                                        </label>
                                        <small class="form-text text-muted d-block">
                                            {{ __('Unpublished items won\'t be visible to users.') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- English Content Section -->
                                <div class="content-section mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">
                                            <i class="fas fa-language mr-1"></i> {{ __('English Content') }}
                                        </h6>
                                        <span class="badge badge-pill badge-primary">EN</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_en">
                                            {{ __('Title') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title_en" id="title_en"
                                               class="form-control form-control-alternative"
                                               placeholder="{{ __('e.g. How to reset your password') }}"
                                               required maxlength="120">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_en">0/120</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_en">
                                            {{ __('Content') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description_en" id="description_en"
                                                  class="form-control form-control-alternative"
                                                  rows="8" placeholder="{{ __('Detailed help content...') }}"
                                                  required maxlength="2000"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_en">0/2000</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary insert-template-btn" data-target="description_en">
                                                <i class="fas fa-magic mr-1"></i> {{ __('Insert Formatting Template') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Section -->
                                <div class="content-section">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">
                                            <i class="fas fa-language mr-1"></i> {{ __('Arabic Content') }}
                                        </h6>
                                        <span class="badge badge-pill badge-primary">AR</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_ar">
                                            {{ __('Title') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title_ar" id="title_ar"
                                               class="form-control form-control-alternative"
                                               placeholder="{{ __('مثال: كيفية إعادة تعيين كلمة المرور') }}"
                                               dir="rtl" required maxlength="120">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_ar">0/120</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_ar">
                                            {{ __('Content') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description_ar" id="description_ar"
                                                  class="form-control form-control-alternative"
                                                  rows="8" placeholder="{{ __('المحتوى المفصل للمساعدة...') }}"
                                                  dir="rtl" required maxlength="2000"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_ar">0/2000</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary insert-template-btn" data-target="description_ar">
                                                <i class="fas fa-magic mr-1"></i> {{ __('إدراج قالب التنسيق') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-center py-4">
                                    <button type="button" class="btn btn-neutral mr-3" onclick="window.location.href='{{ route('support-and-helps.index') }}'">
                                        <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-success px-5" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>{{ __('Publish Support Item') }}
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

@push('css')
<style>
    /* Custom styling for support form */
    .content-section {
        border-left: 4px solid #11cdef;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        background-color: #f8f9fe;
        padding: 1.5rem;
        border-radius: 0.375rem;
    }

    .content-section:hover {
        border-left-width: 6px;
        background-color: #f0f4ff;
    }

    .custom-file-label::after {
        content: attr(data-browse);
    }

    .char-counter {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .form-control-alternative {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        background-color: #fff;
    }

    .form-control-alternative:focus {
        box-shadow: 0 0 0 2px rgba(17, 205, 239, 0.25);
        border-color: #11cdef;
    }

    #imagePreview {
        border: 1px dashed #dee2e6;
        padding: 5px;
        background-color: #f8f9fa;
    }

    .insert-template-btn {
        transition: all 0.2s ease;
    }

    .insert-template-btn:hover {
        transform: translateY(-1px);
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Image preview functionality
        $('#cover_image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                $('.image-preview-container').show();
                $('#removeImageBtn').show();

                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('.custom-file-label').text(file.name);
                }

                reader.readAsDataURL(file);
            }
        });

        // Remove image functionality
        $('#removeImageBtn').click(function() {
            $('#cover_image').val('');
            $('.custom-file-label').text("{{ __('Choose file...') }}");
            $('#imagePreview').hide().attr('src', '');
            $(this).hide();
            $('.image-preview-container').hide();
        });

        // Character counters
        $('[id^="title_"], [id^="description_"]').on('input', function() {
            const target = $(this).attr('id');
            const length = $(this).val().length;
            const maxLength = $(this).attr('maxlength');
            $(`.char-counter[data-target="${target}"]`).text(`${length}/${maxLength}`);

            if (length > maxLength * 0.9) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Form submission handling
        $('#supportItemForm').on('submit', function(e) {
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> {{ __("Saving...") }}');
        });

        // Initialize character counters
        $('[id^="title_"], [id^="description_"]').trigger('input');

        // Template insertion buttons
        $('.insert-template-btn').click(function() {
            const target = $(this).data('target');
            const template = `
## Common Issue

**Problem Description:**
Describe the problem the user is facing...

**Solution Steps:**
1. First step to resolve
2. Second step to resolve
3. Final verification step

**Additional Tips:**
- Helpful tip 1
- Helpful tip 2

**Contact Support:**
If you're still having issues, please contact our support team at support@example.com
            `;

            if (target.includes('_ar')) {
                // Arabic template
                const arabicTemplate = `
## المشكلة الشائعة

**وصف المشكلة:**
صِف المشكلة التي يواجهها المستخدم...

**خطوات الحل:**
1. الخطوة الأولى للحل
2. الخطوة الثانية للحل
3. خطوة التحقق النهائية

**نصائح إضافية:**
- نصيحة مفيدة 1
- نصيحة مفيدة 2

**الاتصال بالدعم:**
إذا كنت لا تزال تواجه مشاكل، يرجى الاتصال بفريق الدعم على support@example.com
                `;
                $(`#${target}`).val(arabicTemplate);
            } else {
                // English template
                $(`#${target}`).val(template);
            }

            // Trigger character count update
            $(`#${target}`).trigger('input');
        });
    });

    // Image size validation
    function validateImageSize(input, maxSizeMB) {
        const file = input.files[0];
        const errorElement = document.getElementById('imageError');

        if (file) {
            const sizeInMB = file.size / (1024 * 1024);
            if (sizeInMB > maxSizeMB) {
                errorElement.textContent = `{{ __("Image size must be less than") }} ${maxSizeMB}MB`;
                input.classList.add('is-invalid');
                input.value = '';
                $('.image-preview-container').hide();
                return false;
            } else {
                input.classList.remove('is-invalid');
                errorElement.textContent = '';
                return true;
            }
        }
    }
</script>
@endpush
