@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Who We Are Details'),
        'description' => __('View detailed information about this entry.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Who We Are Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('who_we_are.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{ __('English Content') }}</h4>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Title') }}</label>
                                        <p class="form-control-static">{{ $whoWeAre->title_en }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description') }}</label>
                                        <p class="form-control-static">{{ $whoWeAre->description_en }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ __('Arabic Content') }}</h4>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Title') }}</label>
                                        <p class="form-control-static">{{ $whoWeAre->title_ar }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description') }}</label>
                                        <p class="form-control-static">{{ $whoWeAre->description_ar }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">{{ __('Cover Image') }}</label>
                                @if ($whoWeAre->cover_image)
                                    <div class="mt-3">
                                        <img src="{{ asset($whoWeAre->cover_image) }}" class="img-fluid" alt="Cover Image">
                                    </div>
                                @else
                                    <p class="form-control-static text-muted">{{ __('No image uploaded') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
