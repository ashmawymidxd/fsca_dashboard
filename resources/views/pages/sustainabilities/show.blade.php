@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Sustainability Details'),
        'class' => 'col-lg-12',
        'description' => __('View complete information about this sustainability initiative'),
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Sustainability Details') }}</h3>
                                <p class="text-sm text-muted mb-0">
                                    {{ __('Complete information about this sustainability initiative') }}</p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sustainabilities.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <!-- Cover Image with Lightbox Preview -->
                        <div class="text-center mb-4">
                            <a href="{{ asset($sustainability->cover_image) }}" data-lightbox="sustainability-cover"
                                data-title="Sustainability Cover Image">
                                <img src="{{ asset($sustainability->cover_image) }}" class="rounded img-fluid shadow-sm"
                                    style="max-height: 300px;width:100%;object-fit:cover; cursor: zoom-in;"
                                    alt="{{ $sustainability->translation('en')->title }} cover image">
                            </a>
                            <small class="text-muted">{{ __('Click image to enlarge') }}</small>
                        </div>

                        <!-- Content Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="sustainabilityTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english"
                                        role="tab" aria-controls="english" aria-selected="true">
                                        <i class="fas fa-language mr-1"></i> {{ __('English') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab"
                                        aria-controls="arabic" aria-selected="false">
                                        <i class="fas fa-language mr-1"></i> {{ __('Arabic') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab"
                                        aria-controls="details" aria-selected="false">
                                        <i class="fas fa-leaf mr-1"></i> {{ __('Sustainability Details') }}
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content border-0" id="sustainabilityTabContent">
                                <!-- English Content Tab -->
                                <div class="tab-pane fade show active p-4" id="english" role="tabpanel"
                                    aria-labelledby="english-tab">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold text-dark">
                                            {{ $sustainability->translation('en')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($sustainability->translation('en')->description)) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Tab -->
                                <div class="tab-pane fade p-4" id="arabic" role="tabpanel" aria-labelledby="arabic-tab"
                                    dir="rtl">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold text-dark">
                                            {{ $sustainability->translation('ar')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($sustainability->translation('ar')->description)) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Details Tab -->
                                <div class="tab-pane fade p-4" id="details" role="tabpanel" aria-labelledby="details-tab">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Status') }}</label>
                                                <p>
                                                    <span
                                                        class="badge badge-pill badge-{{ $sustainability->is_active ? 'success' : 'danger' }}">
                                                        <i
                                                            class="fas {{ $sustainability->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                                        {{ $sustainability->is_active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label text-primary">{{ __('Impact Level') }}</label>
                                                <div class="progress mt-2">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ rand(60, 90) }}%"
                                                        aria-valuenow="{{ rand(60, 90) }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ rand(60, 90) }}%
                                                    </div>
                                                </div>
                                                <small
                                                    class="text-muted">{{ __('Estimated environmental impact') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label text-primary">{{ __('Created At') }}</label>
                                                <p><i
                                                        class="far fa-calendar-alt mr-2"></i>{{ $sustainability->created_at->format('M d, Y \a\t h:i A') }}
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="form-control-label text-primary">{{ __('Last Updated') }}</label>
                                                <p><i
                                                        class="far fa-clock mr-2"></i>{{ $sustainability->updated_at->format('M d, Y \a\t h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label
                                            class="form-control-label text-primary">{{ __('Sustainability Goals') }}</label>
                                        <div class="d-flex flex-wrap">
                                            <span class="badge badge-pill badge-primary mr-2 mb-2">
                                                <i class="fas fa-recycle mr-1"></i> {{ __('Recycling') }}
                                            </span>
                                            <span class="badge badge-pill badge-success mr-2 mb-2">
                                                <i class="fas fa-solar-panel mr-1"></i> {{ __('Renewable Energy') }}
                                            </span>
                                            <span class="badge badge-pill badge-info mr-2 mb-2">
                                                <i class="fas fa-tint mr-1"></i> {{ __('Water Conservation') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <div>
                                <a href="{{ route('sustainabilities.edit', $sustainability) }}"
                                    class="btn btn-info btn-sm mr-2">
                                    <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                                </a>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash-alt mr-1"></i> {{ __('Delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this sustainability initiative? This action cannot be undone.') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('sustainabilities.destroy', $sustainability) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
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
            border-bottom: 2px solid #2dce89;
            color: #2dce89;
        }

        .form-control-label {
            font-weight: 600;
        }

        .card {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .tab-content {
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            border-radius: 0 0 0.25rem 0.25rem;
        }

        .progress {
            height: 1.25rem;
            border-radius: 0.5rem;
        }

        .badge-pill {
            padding: 0.5em 0.75em;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        $(function() {
            // Enable Bootstrap tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Set active tab from URL hash if present
            if (window.location.hash) {
                $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
            }

            // Change URL hash when tab changes
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            });

            // Initialize impact level animation
            $('.progress-bar').each(function() {
                $(this).animate({
                    width: $(this).attr('aria-valuenow') + '%'
                }, 1000);
            });
        });
    </script>
@endpush
