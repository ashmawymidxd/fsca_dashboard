@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Customer Details') . ' ' . $customer->name_en,
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Customer Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">
                                    {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="heading-small text-muted mb-4">{{ __('English Information') }}</h6>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Name') }}</label>
                                        <p class="form-control-plaintext">{{ $customer->name_en }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="heading-small text-muted mb-4">{{ __('Arabic Information') }}</h6>
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Name') }}</label>
                                        <p class="form-control-plaintext">{{ $customer->name_ar }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="heading-small text-muted mb-4">{{ __('Logo') }}</h6>
                                    @if($customer->logo)
                                        <img src="{{ asset($customer->logo) }}" width="150" class="img-thumbnail">
                                    @else
                                        <p>{{ __('No logo uploaded') }}</p>
                                    @endif
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
