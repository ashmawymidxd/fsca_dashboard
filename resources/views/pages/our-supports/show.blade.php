@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Support Details'),
        'description' => __('View details of the support item'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Support Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('our-supports.edit', $ourSupport) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <a href="{{ route('our-supports.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ __('English Version') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Title') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->title_en }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Sub Header') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->sub_header_en }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->description_en }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Button Text') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->button_text_en }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Order') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->order }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="heading-small text-muted mb-4">{{ __('Arabic Version') }}</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Title') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->title_ar }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Sub Header') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->sub_header_ar }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->description_ar }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Button Text') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->button_text_ar }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Created At') }}</label>
                                        <p class="form-control-static">{{ $ourSupport->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
