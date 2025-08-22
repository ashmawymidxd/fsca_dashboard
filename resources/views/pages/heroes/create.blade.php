@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Hero Section'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Hero Section Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('heroes.index') }}" class="btn btn-sm btn-neutral">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('heroes.store') }}" enctype="multipart/form-data" id="hero-form">
                            @csrf

                            <div class="pl-lg-4">
                                <!-- Language Tabs -->
                                <ul class="nav nav-pills mb-4" id="languageTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                            <i class="fas fa-language mr-1"></i> English Content
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                            <i class="fas fa-language mr-1"></i> Arabic Content
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="languageTabsContent">
                                    <!-- English Content Tab -->
                                    <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_en">{{ __('Title (English)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="title_en" id="title_en" class="form-control form-control-alternative" placeholder="Enter hero title in English" required>
                                            <small class="form-text text-muted">This will appear as the main headline</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description_en">{{ __('Description (English)') }} <span class="text-danger">*</span></label>
                                            <textarea name="description_en" id="description_en" class="form-control form-control-alternative" rows="4" placeholder="Enter description in English" required></textarea>
                                            <small class="form-text text-muted">Keep it concise and engaging (max 200 characters)</small>
                                            <div class="text-right">
                                                <span id="description_en_counter">0</span>/200
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="button_text_en">{{ __('Button Text (English)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="button_text_en" id="button_text_en" class="form-control form-control-alternative" placeholder="e.g. Learn More, Get Started" required>
                                        </div>
                                    </div>

                                    <!-- Arabic Content Tab -->
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                        <div class="form-group" dir="rtl">
                                            <label class="form-control-label" for="title_ar">{{ __('Title (Arabic)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="title_ar" id="title_ar" class="form-control form-control-alternative text-right" placeholder="أدخل العنوان الرئيسي بالعربية" required>
                                        </div>
                                        <div class="form-group" dir="rtl">
                                            <label class="form-control-label" for="description_ar">{{ __('Description (Arabic)') }} <span class="text-danger">*</span></label>
                                            <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative text-right" rows="4" placeholder="أدخل الوصف بالعربية" required></textarea>
                                            <small class="form-text text-muted" dir="ltr">Keep it concise and engaging (max 200 characters)</small>
                                            <div class="text-right">
                                                <span id="description_ar_counter">0</span>/200
                                            </div>
                                        </div>
                                        <div class="form-group" dir="rtl">
                                            <label class="form-control-label" for="button_text_ar">{{ __('Button Text (Arabic)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="button_text_ar" id="button_text_ar" class="form-control form-control-alternative text-right" placeholder="مثال: اعرف أكثر, ابدأ الآن" required>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Media Section -->
                                <h6 class="heading-small text-muted mb-4">{{ __('Media') }}</h6>

                                <div class="form-group">
                                    <label class="form-control-label" for="cover_image">{{ __('Cover Image') }} (Max 5MB) <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" id="cover_image" class="custom-file-input" required accept="image/*">
                                        <label class="custom-file-label" for="cover_image">{{ __('Choose image') }}</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended: 1920×1080px, JPG/PNG format</small>
                                    <div class="mt-3" id="image-preview"></div>
                                </div>

                                <hr class="my-4">

                                <!-- Settings Section -->
                                <h6 class="heading-small text-muted mb-4">{{ __('Settings') }}</h6>

                                <div class="form-group">
                                    <label class="form-control-label" for="service_page_slug">{{ __('Select Service Page') }}</label>
                                    <select name="service_page_slug" id="service_page_slug" class="form-control form-control-alternative">
                                        <option value="">{{ __('Select a service page') }}</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->slug_en }}">{{ $service->title_en }} / {{ $service->title_ar }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Select which service page the button will link to</small>
                                </div>

                                <div class="text-center mt-5">
                                    <button type="reset" class="btn btn-outline-secondary mr-3">
                                        <i class="fas fa-redo mr-1"></i> {{ __('Reset') }}
                                    </button>
                                    <button type="submit" class="btn btn-success px-5">
                                        <i class="fas fa-save mr-1"></i> {{ __('Save Hero Section') }}
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
    document.addEventListener('DOMContentLoaded', function() {
        // File input label update
        document.getElementById('cover_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;

            // Image preview
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').innerHTML =
                        '<div class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" style="max-height: 200px;"></div>';
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Character counters for textareas
        const descriptionEn = document.getElementById('description_en');
        const descriptionAr = document.getElementById('description_ar');
        const counterEn = document.getElementById('description_en_counter');
        const counterAr = document.getElementById('description_ar_counter');

        if (descriptionEn && counterEn) {
            descriptionEn.addEventListener('input', function() {
                counterEn.textContent = this.value.length;
            });
        }

        if (descriptionAr && counterAr) {
            descriptionAr.addEventListener('input', function() {
                counterAr.textContent = this.value.length;
            });
        }

        // Form validation
        document.getElementById('hero-form').addEventListener('submit', function(e) {
            let valid = true;

            // Check required fields
            const requiredFields = this.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                // Show error message
                alert('Please fill in all required fields.');
            }
        });
    });
</script>
@endpush

@push('css')
<style>
    .nav-pills .nav-link {
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
    }
    .nav-pills .nav-link.active {
        background-color: #5e72e4;
    }
    .form-control-alternative {
        transition: all 0.15s ease;
        box-shadow: 0 1px 3px rgba(50, 50, 93, 0.15), 0 1px 0 rgba(0, 0, 0, 0.02);
    }
    .form-control-alternative:focus {
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .heading-small {
        font-size: 0.875rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .custom-file-label::after {
        content: "Browse";
    }
</style>
@endpush
