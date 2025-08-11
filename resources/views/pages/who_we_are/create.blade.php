@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Who We Are Entry'),
        'description' => __('Add new content to Who We Are section.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Who We Are Information') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('who_we_are.store') }}" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="title_en">{{ __('Title (English)') }}</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control form-control-alternative" placeholder="{{ __('Title in English') }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_ar">{{ __('Title (Arabic)') }}</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control form-control-alternative" placeholder="{{ __('Title in Arabic') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="description_en">{{ __('Description (English)') }}</label>
                                    <textarea name="description_en" id="description_en" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in English') }}" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="description_ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control form-control-alternative" rows="3" placeholder="{{ __('Description in Arabic') }}" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="cover_image">{{ __('Cover Image') }}</label>
                                    <input type="file" name="cover_image" id="cover_image" class="form-control form-control-alternative" required>
                                    <small class="text-muted">{{ __('Please upload an image (jpeg, png, jpg, gif, svg) with max size 2MB') }}</small>
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
