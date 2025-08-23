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
                        <div class="form-group">
                            <label>{{ __('Title (EN)') }}</label>
                            <input type="text" name="title_en" class="form-control" value="{{ $blog->title_en }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Title (AR)') }}</label>
                            <input type="text" name="title_ar" class="form-control" value="{{ $blog->title_ar }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (EN)') }}</label>
                            <textarea name="description_en" class="form-control" rows="4" required>{{ $blog->description_en }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (AR)') }}</label>
                            <textarea name="description_ar" class="form-control" rows="4" required>{{ $blog->description_ar }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Cover Image') }}</label>
                            <input type="file" name="cover_image" class="form-control">
                            @if($blog->cover_image)
                                <img src="{{ asset($blog->cover_image) }}" class="img-thumbnail mt-2" style="max-width:150px;">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{ __('Image Direction') }}</label>
                            <select name="image_direction" class="form-control" required>
                                <option value="left" {{ $blog->image_direction=='left'?'selected':'' }}>Left</option>
                                <option value="right" {{ $blog->image_direction=='right'?'selected':'' }}>Right</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
