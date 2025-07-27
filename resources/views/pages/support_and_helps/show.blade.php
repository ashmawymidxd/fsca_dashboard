@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Support & Help Details'),
        'class' => 'col-lg-12',
        'description' => __('View complete information about this support resource'),
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Support & Help Details') }}</h3>
                                <p class="text-sm text-muted mb-0">{{ __('Complete information about this support resource') }}</p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('support-and-helps.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <!-- Cover Image with Lightbox Preview -->
                        <div class="text-center mb-4">
                            <a href="{{ asset($supportAndHelp->cover_image) }}" data-lightbox="support-cover" data-title="Support Resource Cover Image">
                                <img src="{{ asset($supportAndHelp->cover_image) }}" class="rounded img-fluid shadow-sm"
                                    style="max-height: 300px;width:100%;object-fit:cover; cursor: zoom-in;"
                                    alt="{{ $supportAndHelp->translation('en')->title }} cover image">
                            </a>
                            <small class="text-muted">{{ __('Click image to enlarge') }}</small>
                        </div>

                        <!-- Content Tabs -->
                        <div class="mb-4">
                            <ul class="nav nav-tabs" id="supportTab" role="tablist">
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

                            <div class="tab-content border-0" id="supportTabContent">
                                <!-- English Content Tab -->
                                <div class="tab-pane fade show active p-4" id="english" role="tabpanel" aria-labelledby="english-tab">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold text-dark">{{ $supportAndHelp->translation('en')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($supportAndHelp->translation('en')->description)) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Content Tab -->
                                <div class="tab-pane fade p-4" id="arabic" role="tabpanel" aria-labelledby="arabic-tab" dir="rtl">
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Title') }}</label>
                                        <p class="font-weight-bold text-dark">{{ $supportAndHelp->translation('ar')->title }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label text-primary">{{ __('Description') }}</label>
                                        <div class="bg-secondary p-3 rounded">
                                            {!! nl2br(e($supportAndHelp->translation('ar')->description)) !!}
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
                                                    <span class="badge badge-pill badge-{{ $supportAndHelp->is_active ? 'success' : 'danger' }}">
                                                        {{ $supportAndHelp->is_active ? __('Active') : __('Inactive') }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Created At') }}</label>
                                                <p>{{ $supportAndHelp->created_at->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Last Updated') }}</label>
                                                <p>{{ $supportAndHelp->updated_at->format('M d, Y \a\t h:i A') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label text-primary">{{ __('Visibility') }}</label>
                                                <p>
                                                    <i class="fas {{ $supportAndHelp->is_active ? 'fa-eye text-success' : 'fa-eye-slash text-danger' }} mr-1"></i>
                                                    {{ $supportAndHelp->is_active ? __('Visible to users') : __('Hidden from users') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <div>
                                <a href="{{ route('support-and-helps.edit', $supportAndHelp) }}" class="btn btn-info btn-sm mr-2">
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this support resource? This action cannot be undone.') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('support-and-helps.destroy', $supportAndHelp) }}" method="POST" class="d-inline">
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
            border-bottom: 2px solid #5e72e4;
            color: #5e72e4;
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
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()

            // Set active tab from URL hash if present
            if(window.location.hash) {
                $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
            }

            // Change URL hash when tab changes
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });
        });
    </script>
@endpush
