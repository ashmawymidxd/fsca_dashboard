@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create Common Unit'),
        'description' => __('Create a new common unit'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-primary">{{ __('Common Unit Information') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('common-units.store') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Images Section --}}
                            <h5 class="text-muted mb-3">{{ __('Upload Images') }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="banner_image">{{ __('Banner Image') }}</label>
                                    <input type="file" name="banner_image" id="banner_image" class="form-control rounded"
                                           onchange="previewImage(event, 'banner_preview')">
                                    <small class="text-muted">Recommended size: 1920x600</small>
                                    <div class="mt-2">
                                        <img id="banner_preview" class="img-fluid rounded shadow-sm d-none" alt="Banner Preview">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="cover_image">{{ __('Cover Image') }}</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control rounded"
                                           onchange="previewImage(event, 'cover_preview')">
                                    <small class="text-muted">Recommended size: 1200x800</small>
                                    <div class="mt-2">
                                        <img id="cover_preview" class="img-fluid rounded shadow-sm d-none" alt="Cover Preview">
                                    </div>
                                </div>
                            </div>

                            {{-- Page & Titles Section --}}
                            <h5 class="text-muted mb-3 mt-4">{{ __('Content Information') }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="page_name">{{ __('Page Name') }}</label>
                                    <select name="page_name" id="page_name" class="form-control rounded" required>
                                        <option value="">{{ __('-- Select Page Name --') }}</option>
                                        <option value="home">Home</option>
                                        <option value="projects">Projects</option>
                                        <option value="support_help">Support & Help</option>
                                        <option value="sustainability">Sustainability</option>
                                        <option value="fleet">Fleet</option>
                                        <option value="train">Train</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="title_en">{{ __('Title (English)') }}</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control rounded" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="title_ar">{{ __('Title (Arabic)') }}</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control rounded text-right" required>
                                </div>
                            </div>

                            {{-- Descriptions Section --}}
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="description_en">{{ __('Description (English)') }}</label>
                                    <textarea name="description_en" id="description_en" class="form-control rounded" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-control-label font-weight-bold" for="description_ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control rounded text-right" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-5 py-2 rounded-pill shadow-sm">
                                    <i class="fas fa-save mr-2"></i> {{ __('Save') }}
                                </button>
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
    function previewImage(event, previewId) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById(previewId);
            preview.src = reader.result;
            preview.classList.remove('d-none');
        };
        if(input.files[0]){
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
