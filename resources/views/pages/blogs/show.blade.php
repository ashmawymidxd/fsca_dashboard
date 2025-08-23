@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('View Blog'),
    'description' => __('View blog details'),
])
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3>{{ $blog->title_en }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>{{ __('Title (AR)') }}:</strong> {{ $blog->title_ar }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Description (EN)') }}:</strong> {{ $blog->description_en }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Description (AR)') }}:</strong> {{ $blog->description_ar }}
                    </div>
                    <div class="mb-3">
                        <strong>{{ __('Image Direction') }}:</strong> {{ ucfirst($blog->image_direction) }}
                    </div>
                    @if($blog->cover_image)
                        <div class="mb-3">
                            <img src="{{ asset($blog->cover_image) }}" class="img-fluid">
                        </div>
                    @endif
                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
