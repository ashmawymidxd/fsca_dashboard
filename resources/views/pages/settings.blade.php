@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Website Settings'),
        'description' => __('Manage your website configuration and social media links.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">{{ __('Website Configuration') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('settings.update') }}" autocomplete="off">
                            @csrf
                            @method('put')

                            {{-- <h6 class="heading-small text-muted mb-4">{{ __('Basic Information') }}</h6> --}}
                            {{-- <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('website_name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="website_name">{{ __('Website Name') }}</label>
                                    <input type="text" name="website_name" id="website_name"
                                        class="form-control form-control-alternative{{ $errors->has('website_name') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Website Name') }}"
                                        value="{{ old('website_name', $settings->website_name ?? '') }}">
                                    @if ($errors->has('website_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('website_description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label"
                                        for="website_description">{{ __('Website Description') }}</label>
                                    <textarea name="website_description" id="website_description"
                                        class="form-control form-control-alternative{{ $errors->has('website_description') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Website Description') }}" rows="3">{{ old('website_description', $settings->website_description ?? '') }}</textarea>
                                    @if ($errors->has('website_description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('website_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div> --}}

                            {{-- <hr class="my-4" /> --}}
                            <h6 class="heading-small text-muted mb-4">{{ __('Contact Information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Email') }}"
                                                value="{{ old('email', $settings->email ?? '') }}" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                for="phone">{{ __('Phone Number') }}</label>
                                            <input type="text" name="phone" id="phone"
                                                class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Phone') }}"
                                                value="{{ old('phone', $settings->phone ?? '') }}">
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('whatsapp') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                for="whatsapp">{{ __('WhatsApp Number') }}</label>
                                            <input type="text" name="whatsapp" id="whatsapp"
                                                class="form-control form-control-alternative{{ $errors->has('whatsapp') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('WhatsApp') }}"
                                                value="{{ old('whatsapp', $settings->whatsapp ?? '') }}">
                                            @if ($errors->has('whatsapp'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('whatsapp') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Location Information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('location_name_en') ? ' has-danger' : '' }}">
                                    <label class="form-control-label"
                                        for="location_name_en">{{ __('Location Name English') }}</label>
                                    <input type="text" name="location_name_en" id="location_name_en"
                                        class="form-control form-control-alternative{{ $errors->has('location_name_en') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('e.g. Company Headquarters') }}"
                                        value="{{ old('location_name_en', $settings->location_name_en ?? '') }}">
                                    @if ($errors->has('location_name_en'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location_name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('location_name_ar') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="location_name_ar">{{ __('Location Name Arabic') }}</label>
                                    <input type="text" name="location_name_ar" id="location_name_ar"
                                        class="form-control form-control-alternative{{ $errors->has('location_name_ar') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('e.g. Company Headquarters') }}"
                                        value="{{ old('location_name_ar', $settings->location_name_ar ?? '') }}">
                                    @if ($errors->has('location_name_ar'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location_name_ar') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('location_link') ? ' has-danger' : '' }}">
                                    <label class="form-control-label"
                                        for="location_link">{{ __('Location Link (Google Maps)') }}</label>
                                    <input type="url" name="location_link" id="location_link"
                                        class="form-control form-control-alternative{{ $errors->has('location_link') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('https://maps.google.com/...') }}"
                                        value="{{ old('location_link', $settings->location_link ?? '') }}">
                                    @if ($errors->has('location_link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location_link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <hr class="my-4" />
                            <h6 class="heading-small text-muted mb-4">{{ __('Social Media Links') }}</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('facebook') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="facebook">{{ __('Facebook') }}</label>
                                            <input type="url" name="facebook" id="facebook"
                                                class="form-control form-control-alternative{{ $errors->has('facebook') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('https://facebook.com/yourpage') }}"
                                                value="{{ old('facebook', $settings->facebook ?? '') }}">
                                            @if ($errors->has('facebook'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('facebook') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('twitter') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="twitter">{{ __('Twitter') }}</label>
                                            <input type="url" name="twitter" id="twitter"
                                                class="form-control form-control-alternative{{ $errors->has('twitter') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('https://twitter.com/yourhandle') }}"
                                                value="{{ old('twitter', $settings->twitter ?? '') }}">
                                            @if ($errors->has('twitter'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('twitter') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('instagram') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                for="instagram">{{ __('Instagram') }}</label>
                                            <input type="url" name="instagram" id="instagram"
                                                class="form-control form-control-alternative{{ $errors->has('instagram') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('https://instagram.com/yourprofile') }}"
                                                value="{{ old('instagram', $settings->instagram ?? '') }}">
                                            @if ($errors->has('instagram'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('instagram') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('linkedin') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="linkedin">{{ __('LinkedIn') }}</label>
                                            <input type="url" name="linkedin" id="linkedin"
                                                class="form-control form-control-alternative{{ $errors->has('linkedin') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('https://linkedin.com/yourcompany') }}"
                                                value="{{ old('linkedin', $settings->linkedin ?? '') }}">
                                            @if ($errors->has('linkedin'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('linkedin') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save Settings') }}</button>
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
        AOS.init()
    </script>
@endpush
