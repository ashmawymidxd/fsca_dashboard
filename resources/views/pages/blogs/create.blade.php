@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create Blog'),
        'description' => __('Add a new blog post'),
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3>{{ __('Create Blog') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group bg-white p-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status-active" name="status" value="active"
                                        class="custom-control-input"
                                        {{ old('status', $blog->status ?? 'active') == 'active' ? 'checked' : '' }}
                                        required>
                                    <label class="custom-control-label text-success font-weight-bold" for="status-active">
                                        <i class="fas fa-check-circle mr-1"></i> Add To Landing Page
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="status-inactive" name="status" value="inactive"
                                        class="custom-control-input"
                                        {{ old('status', $blog->status ?? '') == 'inactive' ? 'checked' : '' }}>
                                    <label class="custom-control-label text-danger font-weight-bold" for="status-inactive">
                                        <i class="fas fa-times-circle mr-1"></i> Hide From Landing Page
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Title (EN)') }}</label>
                                        <input type="text" name="title_en" class="form-control" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Title (AR)') }}</label>
                                        <input type="text" name="title_ar" class="form-control" required>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Description (EN)') }}</label>
                                        <textarea name="description_en" class="form-control" rows="4" required></textarea>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Description (AR)') }}</label>
                                        <textarea name="description_ar" class="form-control" rows="4" required></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Cover Image') }}</label>
                                        <input type="file" name="cover_image" class="form-control" required>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Image Direction') }}</label>
                                        <select name="image_direction" class="form-control" required>
                                            <option value="left">{{ __('Left') }}</option>
                                            <option value="right">{{ __('Right') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
