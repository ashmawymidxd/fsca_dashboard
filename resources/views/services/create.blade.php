@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Service'),
        'description' => __('Add a new service to your system'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Service Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('services.store') }}" autocomplete="off" enctype="multipart/form-data" id="service-form">
                            @csrf

                            <div class="pl-lg-4">
                                <!-- Language Tabs -->
                                <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                            <i class="fas fa-language mr-1"></i> English
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                            <i class="fas fa-language mr-1"></i> العربية
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="langTabsContent">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_en">{{ __('Title') }}</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control form-control-alternative"
                                                   placeholder="{{ __('Service title in English') }}"
                                                   value="{{ old('title_en') }}" required>
                                            <small class="form-text text-muted">{{ __('Keep it concise and descriptive') }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description_en">{{ __('Description') }}</label>
                                            <textarea name="description_en" id="description_en" class="form-control form-control-alternative"
                                                      rows="5" placeholder="{{ __('Detailed description in English') }}"
                                                      required>{{ old('description_en') }}</textarea>
                                            <small class="form-text text-muted">{{ __('Describe the service in detail') }}</small>
                                        </div>
                                    </div>

                                    <!-- Arabic Tab -->
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_ar">{{ __('Title') }}</label>
                                            <input type="text" name="title_ar" id="title_ar" class="form-control form-control-alternative text-right"
                                                   placeholder="{{ __('Service title in Arabic') }}"
                                                   value="{{ old('title_ar') }}" required dir="rtl">
                                            <small class="form-text text-muted">{{ __('Keep it concise and descriptive') }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description_ar">{{ __('Description') }}</label>
                                            <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative text-right"
                                                      rows="5" placeholder="{{ __('Detailed description in Arabic') }}"
                                                      required dir="rtl">{{ old('description_ar') }}</textarea>
                                            <small class="form-text text-muted">{{ __('Describe the service in detail') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cover Image Section -->
                                <div class="form-group mt-4">
                                    <label class="form-control-label" for="cover_image">{{ __('Cover Image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" id="cover_image" class="custom-file-input" required
                                               accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="cover_image">{{ __('Choose image file') }}</label>
                                    </div>
                                    <small class="form-text text-muted">{{ __('Recommended size: 800x600 pixels (JPG, PNG)') }}</small>
                                    <div class="mt-3 text-center" id="image-preview-container" style="display:none;">
                                        <img id="image-preview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-save mr-2"></i> {{ __('Save Service') }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary px-4">
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
    // Show filename when file is selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("cover_image").files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });

    // Image preview functionality
    function previewImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Form validation
    document.getElementById('service-form').addEventListener('submit', function(e) {
        // You can add additional client-side validation here if needed
    });
</script>
@endpush
