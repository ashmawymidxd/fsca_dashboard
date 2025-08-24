
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ $formTitle }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ $formAction }}" autocomplete="off">
                        @csrf
                        @if(isset($support))
                            @method('put')
                        @endif

                        <h6 class="heading-small text-muted mb-4">{{ __('Support Information') }}</h6>

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-title-en">{{ __('Title (English)') }}</label>
                                <input type="text" name="title_en" id="input-title-en" class="form-control form-control-alternative" placeholder="{{ __('Title in English') }}" value="{{ old('title_en', $support->title_en ?? '') }}" required>
                                @error('title_en')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-title-ar">{{ __('Title (Arabic)') }}</label>
                                <input type="text" name="title_ar" id="input-title-ar" class="form-control form-control-alternative" placeholder="{{ __('Title in Arabic') }}" value="{{ old('title_ar', $support->title_ar ?? '') }}" required>
                                @error('title_ar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-sub-header-en">{{ __('Sub Header (English)') }}</label>
                                <input type="text" name="sub_header_en" id="input-sub-header-en" class="form-control form-control-alternative" placeholder="{{ __('Sub Header in English') }}" value="{{ old('sub_header_en', $support->sub_header_en ?? '') }}" required>
                                @error('sub_header_en')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-sub-header-ar">{{ __('Sub Header (Arabic)') }}</label>
                                <input type="text" name="sub_header_ar" id="input-sub-header-ar" class="form-control form-control-alternative" placeholder="{{ __('Sub Header in Arabic') }}" value="{{ old('sub_header_ar', $support->sub_header_ar ?? '') }}" required>
                                @error('sub_header_ar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-description-en">{{ __('Description (English)') }}</label>
                                <textarea name="description_en" id="input-description-en" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in English') }}" required>{{ old('description_en', $support->description_en ?? '') }}</textarea>
                                @error('description_en')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-description-ar">{{ __('Description (Arabic)') }}</label>
                                <textarea name="description_ar" id="input-description-ar" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in Arabic') }}" required>{{ old('description_ar', $support->description_ar ?? '') }}</textarea>
                                @error('description_ar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-button-text-en">{{ __('Button Text (English)') }}</label>
                                <input type="text" name="button_text_en" id="input-button-text-en" class="form-control form-control-alternative" placeholder="{{ __('Button Text in English') }}" value="{{ old('button_text_en', $support->button_text_en ?? '') }}" required>
                                @error('button_text_en')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-button-text-ar">{{ __('Button Text (Arabic)') }}</label>
                                <input type="text" name="button_text_ar" id="input-button-text-ar" class="form-control form-control-alternative" placeholder="{{ __('Button Text in Arabic') }}" value="{{ old('button_text_ar', $support->button_text_ar ?? '') }}" required>
                                @error('button_text_ar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                <a href="{{ route('our-supports.index') }}" class="btn btn-secondary mt-4">{{ __('Cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

