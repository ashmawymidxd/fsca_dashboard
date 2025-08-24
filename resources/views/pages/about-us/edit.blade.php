@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('about us'),
        'description' => __('Here you can manage your about us and view the progress of your work.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">{{ __('about us Overview') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('about-us.update', $aboutU) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">Title (English)</label>
                                        <input type="text" class="form-control" id="title_en" name="title_en"
                                            value="{{ $aboutU->title_en }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description_en" class="form-label">Description (English)</label>
                                        <textarea class="form-control" id="description_en" name="description_en" rows="5" required>{{ $aboutU->description_en }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title_ar" class="form-label">Title (Arabic)</label>
                                        <input type="text" class="form-control" id="title_ar" name="title_ar"
                                            value="{{ $aboutU->title_ar }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description_ar" class="form-label">Description (Arabic)</label>
                                        <textarea class="form-control" id="description_ar" name="description_ar" rows="5" required>{{ $aboutU->description_ar }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="cover_image" class="form-label">Cover Image</label>
                                <input type="file" class="form-control" id="cover_image" name="cover_image"
                                    accept="image/*">
                                @if ($aboutU->cover_image)
                                    <div class="mt-2">
                                        <img src="{{ asset($aboutU->cover_image) }}" alt="Current image"
                                            style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('about-us.index') }}" class="btn btn-secondary">Cancel</a>
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
        AOS.init()
    </script>
@endpush
