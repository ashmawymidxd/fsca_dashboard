@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Project'),
        'description' => __('Update the project details'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Edit Project') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="{{ route('projects.update', $project) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="current_image">{{ __('Current Cover Image') }}</label>
                                    <div>
                                        <img src="{{ asset($project->cover_image) }}" width="150" class="rounded mb-2">
                                    </div>
                                    <label class="form-control-label" for="cover_image">{{ __('Change Cover Image') }}</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control">
                                    <small class="text-muted">{{ __('Leave blank to keep current image') }}</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_active" class="custom-control-input" id="is_active"
                                            {{ $project->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">{{ __('Active') }}</label>
                                    </div>
                                </div>

                                <h6 class="heading-small text-muted mb-4">{{ __('English Content') }}</h6>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_en">{{ __('Title') }}</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control"
                                        value="{{ $project->translation('en')->title ?? '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="description_en">{{ __('Description') }}</label>
                                    <textarea name="description_en" id="description_en" class="form-control" rows="3" required>
                                        {{ $project->translation('en')->description ?? '' }}
                                    </textarea>
                                </div>

                                <h6 class="heading-small text-muted mb-4">{{ __('Arabic Content') }}</h6>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_ar">{{ __('Title') }}</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control" dir="rtl"
                                        value="{{ $project->translation('ar')->title ?? '' }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="description_ar">{{ __('Description') }}</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control" rows="3" dir="rtl" required>
                                        {{ $project->translation('ar')->description ?? '' }}
                                    </textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update Project') }}</button>
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

@push('js')
    <script>
        // Initialize any scripts if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any specific JavaScript for this page here
        });
    </script>
@endpush
