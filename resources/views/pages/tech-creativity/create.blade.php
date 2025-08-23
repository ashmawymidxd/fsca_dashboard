{{-- resources/views/pages/tech-creativity/create.blade.php --}}
@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('Add Tech & Creativity'),
    'description' => __('Create a new banner or category item'),
    'class' => 'col-lg-12',
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">{{ __('New Item') }}</h3>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('tech-creativity.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Type') }}</label>
                                <select name="type" class="form-control" required>
                                    <option value="banner">Banner</option>
                                    <option value="category">Category</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Image Direction') }}</label>
                                <select name="image_direction" class="form-control" required>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                    <option value="center" selected>Center</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Order (next)') }}</label>
                                <input type="number" class="form-control" value="{{ $nextOrder }}" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Title (EN)') }}</label>
                                <input type="text" name="title_en" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Title (AR)') }}</label>
                                <input type="text" name="title_ar" class="form-control" dir="rtl" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description (EN)') }}</label>
                            <textarea name="description_en" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (AR)') }}</label>
                            <textarea name="description_ar" class="form-control" rows="4" dir="rtl" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Cover Image') }}</label>
                            <input type="file" name="cover_image" class="form-control-file" accept="image/*" required>
                            <small class="text-muted">jpeg, png, jpg, gif, webp up to 4MB</small>
                        </div>

                        <button class="btn btn-primary" type="submit">{{ __('Create') }}</button>
                        <a href="{{ route('tech-creativity.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
