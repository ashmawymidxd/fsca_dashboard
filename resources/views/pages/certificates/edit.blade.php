@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Certificate') . ' - ' . $certificate->title_en,
        'description' => __('Update certificate information'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Certificate Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('certificates.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('certificates.update', $certificate) }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <h6 class="heading-small text-muted mb-4">{{ __('Certificate details') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-title-en">{{ __('Title (English)') }}</label>
                                    <input type="text" name="title_en" id="input-title-en" class="form-control form-control-alternative" placeholder="{{ __('Title in English') }}" value="{{ old('title_en', $certificate->title_en) }}" required autofocus>
                                    @error('title_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-title-ar">{{ __('Title (Arabic)') }}</label>
                                    <input type="text" name="title_ar" id="input-title-ar" class="form-control form-control-alternative" placeholder="{{ __('Title in Arabic') }}" value="{{ old('title_ar', $certificate->title_ar) }}" required>
                                    @error('title_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-description-en">{{ __('Description (English)') }}</label>
                                    <textarea name="description_en" id="input-description-en" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in English') }}" required>{{ old('description_en', $certificate->description_en) }}</textarea>
                                    @error('description_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-description-ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea name="description_ar" id="input-description-ar" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in Arabic') }}" required>{{ old('description_ar', $certificate->description_ar) }}</textarea>
                                    @error('description_ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Current Image') }}</label>
                                    <div>
                                        <img src="{{ asset($certificate->cover_image) }}" alt="{{ $certificate->title_en }}" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-cover-image">{{ __('New Cover Image (Leave blank to keep current)') }}</label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" class="custom-file-input" id="input-cover-image">
                                        <label class="custom-file-label" for="input-cover-image">{{ __('Choose new image') }}</label>
                                    </div>
                                    @error('cover_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        {{ __('Supported formats: jpeg, png, jpg, gif. Max size: 2MB') }}
                                    </small>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update Certificate') }}</button>
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
        // Show selected file name
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>
@endpush
