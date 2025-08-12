@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Customer'),
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
                        <form method="post" action="{{ route('customers.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name_en') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name_en">{{ __('Name (English)') }}</label>
                                    <input type="text" name="name_en" id="name_en" class="form-control form-control-alternative{{ $errors->has('name_en') ? ' is-invalid' : '' }}" placeholder="{{ __('Name in English') }}" value="{{ old('name_en') }}" required autofocus>
                                    @if ($errors->has('name_en'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('name_ar') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="name_ar">{{ __('Name (Arabic)') }}</label>
                                    <input type="text" name="name_ar" id="name_ar" class="form-control form-control-alternative{{ $errors->has('name_ar') ? ' is-invalid' : '' }}" placeholder="{{ __('Name in Arabic') }}" value="{{ old('name_ar') }}" required>
                                    @if ($errors->has('name_ar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('logo') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="logo">{{ __('Logo') }}</label>
                                    <input type="file" name="logo" id="logo" class="form-control form-control-alternative{{ $errors->has('logo') ? ' is-invalid' : '' }}" required>
                                    @if ($errors->has('logo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('logo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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
