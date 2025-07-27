@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Sustainability Initiative'),
        'description' => __('Add new sustainability programs, environmental initiatives or corporate responsibility content.'),
        'class' => 'col-lg-12',
        'breadcrumbs' => [
            ['url' => route('sustainabilities.index'), 'name' => __('Sustainability')],
            ['name' => __('Create New')]
        ]
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <!-- Card Header with Environmental Theme -->
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">
                                <i class="fas fa-leaf text-success mr-2"></i>
                                {{ __('Sustainability Details') }}
                            </h3>
                            <span class="badge badge-pill badge-success">
                                <i class="fas fa-plus mr-1"></i> {{ __('New Initiative') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('sustainabilities.store') }}" enctype="multipart/form-data" id="sustainabilityForm">
                            @csrf

                            <div class="pl-lg-4 pr-lg-4">
                                <!-- Cover Image with Eco-themed Upload -->
                                <div class="form-group">
                                    <label class="form-control-label d-block" for="cover_image">
                                        {{ __('Initiative Image') }}
                                        <small class="text-muted">{{ __('(Recommended: 1200×800px, Max 2MB)') }}</small>
                                    </label>
                                    <div class="image-upload-wrapper">
                                        <div class="image-preview-container text-center mb-3" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Initiative preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; display: none;">
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
                                                {{ __('Choose sustainable image...') }}
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ __('Showcase your sustainability efforts with a high-quality image.') }}
                                        </small>
                                        <div class="invalid-feedback" id="imageError"></div>
                                    </div>
                                </div>

                                <!-- Active Status with Eco-friendly Toggle -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-success">
                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                        <label class="custom-control-label" for="is_active">
                                            <span class="font-weight-600">{{ __('Publish Initiative') }}</span>
                                        </label>
                                        <small class="form-text text-muted d-block">
                                            {{ __('Only published initiatives appear in public sustainability reports.') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- English Content Section -->
                                <div class="content-section mb-5" style="border-left-color: #2dce89;">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">
                                            <i class="fas fa-globe-americas mr-1"></i> {{ __('English Content') }}
                                        </h6>
                                        <span class="badge badge-pill badge-success">EN</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_en">
                                            {{ __('Initiative Title') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title_en" id="title_en"
                                               class="form-control form-control-alternative"
                                               placeholder="{{ __('e.g. Carbon Neutral 2030 Program') }}"
                                               required maxlength="100">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_en">0/100</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_en">
                                            {{ __('Detailed Description') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description_en" id="description_en"
                                                  class="form-control form-control-alternative"
                                                  rows="6" placeholder="{{ __('Describe your sustainability goals, methods and impact...') }}"
                                                  required maxlength="1500"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_en">0/1500</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-success insert-template-btn" data-target="description_en">
                                                <i class="fas fa-seedling mr-1"></i> {{ __('Insert Sustainability Template') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Section -->
                                <div class="content-section" style="border-left-color: #2dce89;">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">
                                            <i class="fas fa-globe-africa mr-1"></i> {{ __('Arabic Content') }}
                                        </h6>
                                        <span class="badge badge-pill badge-success">AR</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_ar">
                                            {{ __('Initiative Title') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title_ar" id="title_ar"
                                               class="form-control form-control-alternative"
                                               placeholder="{{ __('مثال: برنامج الحياد الكربوني 2030') }}"
                                               dir="rtl" required maxlength="100">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_ar">0/100</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_ar">
                                            {{ __('Detailed Description') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="description_ar" id="description_ar"
                                                  class="form-control form-control-alternative"
                                                  rows="6" placeholder="{{ __('صف أهداف الاستدامة والطرق المستخدمة والأثر المتوقع...') }}"
                                                  dir="rtl" required maxlength="1500"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_ar">0/1500</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-success insert-template-btn" data-target="description_ar">
                                                <i class="fas fa-seedling mr-1"></i> {{ __('إدراج قالب الاستدامة') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-center py-4">
                                    <button type="button" class="btn btn-neutral mr-3" onclick="window.location.href='{{ route('sustainabilities.index') }}'">
                                        <i class="fas fa-times mr-2"></i>{{ __('Cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-success px-5" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>{{ __('Save Sustainability Initiative') }}
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
    /* Eco-friendly theme styling */
    .content-section {
        border-left: 4px solid #2dce89;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        background-color: #f8fff9;
        padding: 1.5rem;
        border-radius: 0.375rem;
    }

    .content-section:hover {
        border-left-width: 6px;
        background-color: #f0fff4;
    }

    .custom-switch-success .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #2dce89;
        border-color: #2dce89;
    }

    .custom-file-label::after {
        content: attr(data-browse);
        background-color: #e9f7ef;
        color: #2dce89;
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
        box-shadow: 0 0 0 2px rgba(45, 206, 137, 0.25);
        border-color: #2dce89;
    }

    #imagePreview {
        border: 1px dashed #dee2e6;
        padding: 5px;
        background-color: #f8f9fa;
    }

    .insert-template-btn {
        transition: all 0.2s ease;
        border-color: #2dce89;
        color: #2dce89;
    }

    .insert-template-btn:hover {
        transform: translateY(-1px);
        background-color: rgba(45, 206, 137, 0.1);
    }

    .badge-success {
        background-color: #2dce89;
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
            $('.custom-file-label').text("{{ __('Choose sustainable image...') }}");
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
        $('#sustainabilityForm').on('submit', function(e) {
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> {{ __("Saving...") }}');
        });

        // Initialize character counters
        $('[id^="title_"], [id^="description_"]').trigger('input');

        // Sustainability template insertion
        $('.insert-template-btn').click(function() {
            const target = $(this).data('target');
            const template = `
## Initiative Overview

**Sustainability Goals:**
- Clearly state your environmental objectives
- Align with global SDGs if applicable

**Implementation Strategy:**
1. Phase 1: Initial actions
2. Phase 2: Scaling efforts
3. Phase 3: Long-term maintenance

**Measurable Impact:**
- CO2 reduction: X tons annually
- Energy savings: X kWh per year
- Waste reduction: X% improvement

**Partners & Collaborators:**
- List any environmental organizations involved
- Government or NGO partnerships

**Future Roadmap:**
- Upcoming sustainability targets
- Planned eco-friendly innovations
            `;

            if (target.includes('_ar')) {
                // Arabic template
                const arabicTemplate = `
## نظرة عامة على المبادرة

**أهداف الاستدامة:**
- اذكر أهدافك البيئية بوضوح
- المحاذاة مع أهداف التنمية المستدامة العالمية إذا كانت ذات صلة

**استراتيجية التنفيذ:**
1. المرحلة 1: الإجراءات الأولية
2. المرحلة 2: توسيع الجهود
3. المرحلة 3: الصيانة طويلة الأجل

**الأثر القابل للقياس:**
- تخفيض CO2: X طن سنوياً
- توفير الطاقة: X كيلوواط ساعة سنوياً
- تقليل النفايات: تحسن بنسبة X٪

**الشركاء والمتعاونون:**
- اذكر أي منظمات بيئية مشاركة
- الشراكات الحكومية أو مع المنظمات غير الحكومية

**خارطة الطريق المستقبلية:**
- أهداف الاستدامة القادمة
- الابتكارات الصديقة للبيئة المخطط لها
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
