@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Projects'),
        'description' => __('Here you can manage your projects and view the progress of your work.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">{{ __('Projects Overview') }}</h3>
                    </div>
                    <div class="card-body">
                        <div >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>English Content</h3>
                                        <p><strong>Title:</strong> {{ $aboutU->title_en }}</p>
                                        <p><strong>Description:</strong> {{ $aboutU->description_en }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Arabic Content</h3>
                                        <p><strong>Title:</strong> {{ $aboutU->title_ar }}</p>
                                        <p><strong>Description:</strong> {{ $aboutU->description_ar }}</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h3>Image</h3>
                                    <img src="{{ asset($aboutU->cover_image) }}" alt="About Us Image" class="img-fluid"
                                        style="max-width: 400px;">
                                </div>

                                <div class="mt-3">
                                    <p><strong>Order:</strong> {{ $aboutU->order }}</p>
                                    <p><strong>Created:</strong> {{ $aboutU->created_at->format('M d, Y') }}</p>
                                    <p><strong>Last Updated:</strong> {{ $aboutU->updated_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('about-us.edit', $aboutU) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('about-us.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        AOS.init()
    </script>
@endpush
