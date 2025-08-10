@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Service'),
        'description' => __('Update the service information.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Service Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('complete_services.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('complete_services.update', $completeService) }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <h6 class="heading-small text-muted mb-4">{{ __('Service details') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('title_en') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title-en">{{ __('English Title') }}</label>
                                    <input type="text" name="title_en" id="input-title-en"
                                        class="form-control form-control-alternative{{ $errors->has('title_en') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Service title in English') }}"
                                        value="{{ old('title_en', $completeService->title_en) }}" required autofocus>
                                    @if ($errors->has('title_en'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title_en') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('title_ar') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title-ar">{{ __('Arabic Title') }}</label>
                                    <input type="text" name="title_ar" id="input-title-ar"
                                        class="form-control form-control-alternative{{ $errors->has('title_ar') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Service title in Arabic') }}"
                                        value="{{ old('title_ar', $completeService->title_ar) }}" required>
                                    @if ($errors->has('title_ar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Current Image') }}</label>
                                    <div>
                                        <img src="{{ asset($completeService->image_path) }}" alt="{{ $completeService->title }}"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label"
                                        for="input-image">{{ __('New Cover Image (Leave blank to keep current)') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="image"
                                            class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                            id="input-image">
                                        <label class="custom-file-label"
                                            for="input-image">{{ __('Choose new image') }}</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        {{ __('Recommended size: 800x600 pixels. Max file size: 2MB.') }}
                                    </small>
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
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
        // Update the custom file input label to show the selected file name
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById('input-image').files[0]?.name || '{{ __('Choose new image') }}';
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endpush
