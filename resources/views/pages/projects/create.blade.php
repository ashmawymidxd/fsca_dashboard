@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Project'),
        'description' => __('Here you can manage your projects and view the progress of your work.'),
        'class' => 'col-lg-12',
        'breadcrumbs' => [
            ['url' => route('projects.index'), 'name' => __('Projects')],
            ['name' => __('Create New')]
        ]
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <!-- Card Header with Progress Indicator -->
                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">{{ __('Project Information') }}</h3>
                            <span class="badge badge-pill badge-primary">Step 1 of 2</span>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data" id="projectForm">
                            @csrf

                            <div class="pl-lg-4 pr-lg-4">
                                <!-- Cover Image Upload with Preview -->
                                <div class="form-group">
                                    <label class="form-control-label d-block" for="cover_image">
                                        {{ __('Cover Image') }}
                                        <small class="text-muted">(Recommended size: 1200×630px)</small>
                                    </label>
                                    <div class="image-upload-wrapper mb-3">
                                        <div class="image-preview-container text-center mb-3" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Cover preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; display: none;">
                                            <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImageBtn" style="display: none;">
                                                <i class="fas fa-trash mr-1"></i> Remove Image
                                            </button>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" id="cover_image" class="custom-file-input" accept="image/*" required
                                                   aria-describedby="coverImageHelp">
                                            <label class="custom-file-label" for="cover_image" data-browse="{{ __('Browse') }}">
                                                {{ __('Choose file...') }}
                                            </label>
                                        </div>
                                        <small id="coverImageHelp" class="form-text text-muted">
                                            {{ __('Upload a high-quality image that represents your project.') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Active Toggle Switch -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                        <label class="custom-control-label" for="is_active">{{ __('Active Project') }}</label>
                                        <small class="form-text text-muted d-block">
                                            {{ __('Inactive projects won\'t be visible to the public.') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- English Content Section -->
                                <div class="content-section mb-5">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">{{ __('English Content') }}</h6>
                                        <span class="badge badge-pill badge-info">EN</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_en">{{ __('Title') }}</label>
                                        <input type="text" name="title_en" id="title_en" class="form-control form-control-alternative"
                                               placeholder="{{ __('e.g. Website Redesign Project') }}" required
                                               maxlength="100">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_en">0/100</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_en">{{ __('Description') }}</label>
                                        <textarea name="description_en" id="description_en" class="form-control form-control-alternative"
                                                  rows="5" placeholder="{{ __('Describe your project in detail...') }}"
                                                  required maxlength="500"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_en">0/500</small>
                                    </div>
                                </div>

                                <!-- Arabic Content Section -->
                                <div class="content-section">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h6 class="heading-small text-muted mb-0">{{ __('Arabic Content') }}</h6>
                                        <span class="badge badge-pill badge-info">AR</span>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="title_ar">{{ __('Title') }}</label>
                                        <input type="text" name="title_ar" id="title_ar" class="form-control form-control-alternative"
                                               placeholder="{{ __('e.g. مشروع إعادة تصميم الموقع') }}" dir="rtl"
                                               required maxlength="100">
                                        <small class="form-text text-muted float-right char-counter" data-target="title_ar">0/100</small>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="description_ar">{{ __('Description') }}</label>
                                        <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative"
                                                  rows="5" placeholder="{{ __('صف مشروعك بالتفصيل...') }}" dir="rtl"
                                                  required maxlength="500"></textarea>
                                        <small class="form-text text-muted float-right char-counter" data-target="description_ar">0/500</small>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-center py-4">
                                    <button type="button" class="btn btn-secondary mr-3" onclick="window.history.back()">
                                        <i class="fas fa-arrow-left mr-2"></i>{{ __('Cancel') }}
                                    </button>
                                    <button type="submit" class="btn btn-success px-5" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>{{ __('Save Project') }}
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
    /* Custom styling for better UX */
    .content-section {
        border-left: 4px solid #5e72e4;
        padding-left: 1.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .content-section:hover {
        border-left-width: 6px;
        padding-left: 1.3rem;
    }

    .custom-file-label::after {
        content: attr(data-browse);
    }

    .char-counter {
        font-size: 0.75rem;
    }

    .form-control-alternative {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control-alternative:focus {
        box-shadow: 0 0 0 2px rgba(94, 114, 228, 0.25);
    }

    #imagePreview {
        border: 1px dashed #dee2e6;
        padding: 5px;
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
        $('#projectForm').on('submit', function(e) {
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span> Saving...');
        });

        // Initialize character counters
        $('[id^="title_"], [id^="description_"]').trigger('input');
    });
</script>
@endpush
