@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Video Details'),
        'description' => __('View details of your video.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $video->title }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('videos.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="heading-small text-muted mb-4">Video Information</h6>
                                <p><strong>Title:</strong> {{ $video->title }}</p>
                                <p><strong>Uploaded:</strong> {{ $video->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="heading-small text-muted mb-4">Video Preview</h6>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video controls class="embed-responsive-item">
                                        <source src="{{ asset($video->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('videos.destroy', $video->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
