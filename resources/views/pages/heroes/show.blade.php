@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Hero Section Details'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Hero Section Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('heroes.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>{{ __('English Content') }}</h4>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Title') }}</label>
                                    <p class="form-control-static">{{ $hero->title_en }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Description') }}</label>
                                    <p class="form-control-static">{{ $hero->description_en }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Button Text') }}</label>
                                    <p class="form-control-static">{{ $hero->button_text_en }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>{{ __('Arabic Content') }}</h4>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Title') }}</label>
                                    <p class="form-control-static">{{ $hero->title_ar }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Description') }}</label>
                                    <p class="form-control-static">{{ $hero->description_ar }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Button Text') }}</label>
                                    <p class="form-control-static">{{ $hero->button_text_ar }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Cover Image') }}</label>
                                    <div>
                                        @if($hero->cover_image)
                                            <img src="{{ asset($hero->cover_image) }}" class="img-fluid" style="max-height: 400px;" alt="Hero Image">
                                        @else
                                            <p>No image uploaded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('heroes.edit', $hero) }}" class="btn btn-primary">
                                {{ __('Edit Hero Section') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
