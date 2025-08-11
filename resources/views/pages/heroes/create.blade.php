@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Hero Section'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Hero Section Information') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('heroes.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="title_en">{{ __('Title (English)') }}</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_ar">{{ __('Title (Arabic)') }}</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="description_en">{{ __('Description (English)') }}</label>
                                    <textarea name="description_en" id="description_en" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="description_ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="button_text_en">{{ __('Button Text (English)') }}</label>
                                    <input type="text" name="button_text_en" id="button_text_en" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="button_text_ar">{{ __('Button Text (Arabic)') }}</label>
                                    <input type="text" name="button_text_ar" id="button_text_ar" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="cover_image">{{ __('Cover Image') }} (Max
                                        5MB)</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="service_page_slug">{{ __('Select Service Page') }}</label>
                                    <select name="service_page_slug" id="service_page_slug" class="form-control">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->slug_en }}">{{ $service->title_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Service --}}
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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
