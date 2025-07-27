@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Project Details'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Project Details') }}</h3>
                                <p class="text-sm text-muted mb-0">{{ __('Complete information about the project') }}</p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <!-- Cover Image with Lightbox Preview -->
                        <div class="text-center mb-4 w-100">
                            <a href="{{ asset($project->cover_image) }}" data-lightbox="project-cover" data-title="Project Cover Image">
                                <img src="{{ asset($project->cover_image) }}" class="rounded img-fluid shadow-sm"
                                    style="max-height: 300px;width:100%;object-fit:cover; cursor: zoom-in;"
                                    alt="{{ $project->translation('en')->title }} cover image">
                            </a>
                            <small class="text-muted">{{ __('Click image to enlarge') }}</small>
                        </div>

                        <!-- Project Details Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="projectTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                        <i class="fas fa-language mr-1"></i> {{ __('English') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                        <i class="fas fa-language mr-1"></i> {{ __('Arabic') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">
                                        <i class="fas fa-info-circle mr-1"></i> {{ __('Details') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="projectTabContent">
                                <!-- English Content Tab -->
                                <div class="tab-pane fade show active p-4" id="english" role="tabpanel" aria-labelledby="english-tab">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold">{{ $project->translation('en')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($project->translation('en')->description)) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Tab -->
                                <div class="tab-pane fade p-4" id="arabic" role="tabpanel" aria-labelledby="arabic-tab" dir="rtl">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold">{{ $project->translation('ar')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($project->translation('ar')->description)) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Project Details Tab -->
                                <div class="tab-pane fade p-4" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Status') }}</label>
                                                <p>
                                                    <span class="badge badge-pill badge-{{ $project->is_active ? 'success' : 'danger' }}">
                                                        {{ $project->is_active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Created At') }}</label>
                                                <p>{{ $project->created_at->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Last Updated') }}</label>
                                                <p>{{ $project->updated_at->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <div>
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        .nav-tabs .nav-link {
            color: #525f7f;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #5e72e4;
            color: #5e72e4;
        }
        .form-control-label {
            font-weight: 600;
        }
        .card {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
