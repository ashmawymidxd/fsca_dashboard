@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Hero Section'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit Hero Section') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('heroes.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('heroes.update', $hero) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>{{ __('English Content') }}</h4>
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_en">{{ __('Title') }}</label>
                                            <input type="text" name="title_en" id="title_en" class="form-control" value="{{ old('title_en', $hero->title_en) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description_en">{{ __('Description') }}</label>
                                            <textarea name="description_en" id="description_en" class="form-control" rows="3" required>{{ old('description_en', $hero->description_en) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="button_text_en">{{ __('Button Text') }}</label>
                                            <input type="text" name="button_text_en" id="button_text_en" class="form-control" value="{{ old('button_text_en', $hero->button_text_en) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>{{ __('Arabic Content') }}</h4>
                                        <div class="form-group">
                                            <label class="form-control-label" for="title_ar">{{ __('Title') }}</label>
                                            <input type="text" name="title_ar" id="title_ar" class="form-control" value="{{ old('title_ar', $hero->title_ar) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="description_ar">{{ __('Description') }}</label>
                                            <textarea name="description_ar" id="description_ar" class="form-control" rows="3" required>{{ old('description_ar', $hero->description_ar) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label" for="button_text_ar">{{ __('Button Text') }}</label>
                                            <input type="text" name="button_text_ar" id="button_text_ar" class="form-control" value="{{ old('button_text_ar', $hero->button_text_ar) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="cover_image">{{ __('Cover Image') }} (Max 5MB)</label>
                                            <input type="file" name="cover_image" id="cover_image" class="form-control">
                                            @if($hero->cover_image)
                                                <div class="mt-3">
                                                    <label class="form-control-label">{{ __('Current Image') }}</label>
                                                    <img src="{{ asset($hero->cover_image) }}" class="img-fluid" style="max-height: 200px;" alt="Current Hero Image">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
        // You can add any specific JavaScript for this page here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Initialize any needed plugins
        });
    </script>
@endpush
