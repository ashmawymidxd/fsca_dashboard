@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Common Unit'),
        'description' => __('Edit common unit information'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Common Unit Information') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('common-units.update', $commonUnit) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="title_en">{{ __('Title (English)') }}</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control"
                                        value="{{ $commonUnit->title_en }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_ar">{{ __('Title (Arabic)') }}</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control"
                                        value="{{ $commonUnit->title_ar }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="title_ar">{{ __('Page Name') }}</label>
                                    <input type="text" name="page_name" id="page_name" class="form-control"
                                        value="{{ $commonUnit->page_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="description_en">{{ __('Description (English)') }}</label>
                                    <textarea name="description_en" id="description_en" class="form-control" rows="3" required>{{ $commonUnit->description_en }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="description_ar">{{ __('Description (Arabic)') }}</label>
                                    <textarea name="description_ar" id="description_ar" class="form-control" rows="3" required>{{ $commonUnit->description_ar }}</textarea>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
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
