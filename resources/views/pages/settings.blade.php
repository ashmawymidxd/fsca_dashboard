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
                        {{-- errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('settings.update') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Basic Information') }}</h6>
                            <div class="row pl-lg-4">
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group{{ $errors->has('website_name_en') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                for="website_name_en">{{ __('Website Name English') }}</label>
                                            <input type="text" name="website_name_en" id="website_name_en"
                                                class="form-control form-control-alternative{{ $errors->has('website_name_en') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Website Name') }}"
                                                value="{{ old('website_name_en', $settings->website_name_en ?? '') }}">
                                            @if ($errors->has('website_name_en'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('website_name_en') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group{{ $errors->has('website_name_ar') ? ' has-danger' : '' }}">
                                            <label class="form-control-label"
                                                for="website_name_ar">{{ __('Website Name Arabic') }}</label>
                                            <input type="text" name="website_name_ar" id="website_name_ar"
                                                class="form-control form-control-alternative{{ $errors->has('website_name_ar') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Website Name') }}"
                                                value="{{ old('website_name_ar', $settings->website_name_ar ?? '') }}">
                                            @if ($errors->has('website_name_ar'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('website_name_ar') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pl-lg-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description (EN)') }}</label>
                                        <textarea name="description_en" class="form-control" rows="4">
                                            {{ old('description_en', $settings->description_en ?? '') }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">{{ __('Description (AR)') }}</label>
                                        <textarea name="description_ar" class="form-control" rows="4" dir="rtl">
                                            {{ old('description_ar', $settings->description_ar ?? '') }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Maintenance Mode Switch Here -->
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Maintenance Mode') }}</label>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="maintenance_mode" value="0">
                                        <input type="checkbox" name="maintenance_mode" id="maintenance_mode"
                                            class="custom-control-input" value="1"
                                            {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="maintenance_mode">
                                            {{ __('Enable Maintenance Mode') }}
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        {{ __('When enabled, the website will display a maintenance page to visitors.') }}
                                    </small>
                                </div>
                            </div>

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Logo Upload Section -->
                                        <div class="form-group border rounded p-2 bg-white">
                                            <label class="form-control-label"
                                                for="logo">{{ __('Website Logo') }}</label>
                                            @if ($settings->logo ?? false)
                                                <div class="mb-3">
                                                    <img src="{{ asset($settings->logo) }}" alt="Current Logo"
                                                        class="img-thumbnail" style="max-height: 100px;">
                                                    <div class="mt-2">
                                                        <a href="{{ asset($settings->logo) }}" target="_blank"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> View Full Size
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" name="logo" id="logo"
                                                    class="custom-file-input">
                                                <label class="custom-file-label"
                                                    for="logo">{{ __('Choose new logo') }}</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Recommended size: 300x100 pixels. Allowed formats: jpeg, png, jpg, gif, svg.') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- PDF Upload Section -->
                                        <div class="form-group border rounded p-2 bg-white">
                                            <label class="form-control-label" for="pdf">{{ __('PDF File') }}</label>
                                            @if ($settings->pdf ?? false)
                                                <div class="mb-3">
                                                    <div class="alert alert-secondary d-flex align-items-center">
                                                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"
                                                            style="font-size: 100px"></i>
                                                        <div>
                                                            <h5 class="mb-0">{{ __('Current PDF File') }}</h5>
                                                            <a href="{{ asset($settings->pdf) }}" target="_blank"
                                                                class="btn btn-sm btn-primary mt-1">
                                                                <i class="fas fa-download"></i> Download PDF
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" name="pdf" id="pdf"
                                                    class="custom-file-input">
                                                <label class="custom-file-label"
                                                    for="pdf">{{ __('Choose new PDF file') }}</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Maximum file size: 100MB. Allowed format: PDF.') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rest of your form remains the same -->
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
                                    <label class="form-control-label"
                                        for="location_name_ar">{{ __('Location Name Arabic') }}</label>
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
        AOS.init();

        // Show file names when files are selected
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : '{{ __('Choose file') }}';
                var label = e.target.nextElementSibling;
                label.textContent = fileName;
            });
        });

        // Preview image before upload
        document.getElementById('logo').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var preview = document.createElement('div');
                    preview.className = 'mb-3';
                    preview.innerHTML = `
                        <img src="${event.target.result}" alt="New logo preview" class="img-thumbnail" style="max-height: 150px;">
                        <div class="mt-2">
                            <span class="badge badge-info">New logo preview</span>
                        </div>
                    `;
                    var container = e.target.closest('.form-group');
                    var existingPreview = container.querySelector('.mb-3');
                    if (existingPreview) {
                        container.insertBefore(preview, existingPreview.nextSibling);
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
@endpush
