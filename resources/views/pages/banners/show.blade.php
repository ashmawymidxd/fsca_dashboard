@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('Banner Details'),
    'description' => __('View banner information'),
    'class' => 'col-lg-12',
])
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">{{ __('Banner Details') }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ __('Title (EN)') }}</label>
                        <p class="form-control-plaintext">{{ $banner->title_en }}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Title (AR)') }}</label>
                        <p class="form-control-plaintext">{{ $banner->title_ar }}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Description (EN)') }}</label>
                        <p class="form-control-plaintext">{{ $banner->description_en }}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Description (AR)') }}</label>
                        <p class="form-control-plaintext">{{ $banner->description_ar }}</p>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Cover Image') }}</label><br>
                        <img src="{{ asset($banner->cover_image) }}" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                    <a href="{{ route('banners.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
