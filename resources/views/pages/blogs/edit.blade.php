@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Blog'),
        'description' => __('Edit existing blog post'),
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3>{{ __('Edit Blog') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group bg-white p-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status-active" name="status" value="active"
                                        class="custom-control-input"
                                        {{ old('status', $blog->status) == 'active' ? 'checked' : '' }} required>
                                    <label class="custom-control-label text-success font-weight-bold" for="status-active">
                                        <i class="fas fa-eye mr-1"></i> Show on Landing Page
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status-inactive" name="status" value="inactive"
                                        class="custom-control-input"
                                        {{ old('status', $blog->status) == 'inactive' ? 'checked' : '' }}>
                                    <label class="custom-control-label text-light font-weight-bold" for="status-inactive">
                                        <i class="fas fa-eye-slash mr-1"></i> Hide from Landing Page
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Title (EN)') }}</label>
                                        <input type="text" name="title_en" class="form-control"
                                            value="{{ $blog->title_en }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Title (AR)') }}</label>
                                        <input type="text" name="title_ar" class="form-control"
                                            value="{{ $blog->title_ar }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Description (EN)') }}</label>
                                        <textarea name="description_en" class="form-control" rows="4" required>{{ $blog->description_en }}</textarea>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Description (AR)') }}</label>
                                        <textarea name="description_ar" class="form-control" rows="4" required>{{ $blog->description_ar }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Cover Image') }}</label>
                                        <input type="file" name="cover_image" class="form-control">
                                        @if ($blog->cover_image)
                                            <img src="{{ asset($blog->cover_image) }}" class="img-thumbnail mt-2"
                                                style="max-width:150px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Image Direction') }}</label>
                                        <select name="image_direction" class="form-control" required>
                                            <option value="left"
                                                {{ $blog->image_direction == 'left' ? 'selected' : '' }}>Left
                                            </option>
                                            <option value="right"
                                                {{ $blog->image_direction == 'right' ? 'selected' : '' }}>Right
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
