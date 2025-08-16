@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Common Unit Details'),
        'description' => __('View common unit details'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Common Unit Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('common-units.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{ __('Banner Image') }}</h4>
                                    <img src="{{ asset($commonUnit->banner_image) }}" class="img-fluid" alt="Banner Image">
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ __('Cover Image') }}</h4>
                                    <img src="{{ asset($commonUnit->cover_image) }}" class="img-fluid" alt="Cover Image">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h4>{{ __('Title (English)') }}</h4>
                                    <p>{{ $commonUnit->title_en }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ __('Title (Arabic)') }}</h4>
                                    <p>{{ $commonUnit->title_ar }}</p>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h4>{{ __('Description (English)') }}</h4>
                                    <p>{{ $commonUnit->description_en }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ __('Description (Arabic)') }}</h4>
                                    <p>{{ $commonUnit->description_ar }}</p>
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
