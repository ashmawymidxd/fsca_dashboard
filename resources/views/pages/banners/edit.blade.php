@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('Edit Banner'),
    'description' => __('Update banner details'),
    'class' => 'col-lg-12',
])
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">{{ __('Edit Banner') }}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('banners.update', $banner) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('Title (EN)') }}</label>
                            <input type="text" name="title_en" class="form-control" value="{{ $banner->title_en }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Title (AR)') }}</label>
                            <input type="text" name="title_ar" class="form-control" value="{{ $banner->title_ar }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (EN)') }}</label>
                            <textarea name="description_en" class="form-control" rows="4" required>{{ $banner->description_en }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (AR)') }}</label>
                            <textarea name="description_ar" class="form-control" rows="4" required>{{ $banner->description_ar }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Cover Image') }}</label>
                            <input type="file" name="cover_image" class="form-control">
                            @if($banner->cover_image)
                                <img src="{{ asset($banner->cover_image) }}" alt="" class="img-thumbnail mt-2" style="max-width: 150px;">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
