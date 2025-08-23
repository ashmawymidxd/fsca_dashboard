{{-- resources/views/pages/tech-creativity/edit.blade.php --}}
@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('Edit Tech & Creativity'),
    'description' => __('Update item details'),
    'class' => 'col-lg-12',
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <h3 class="mb-0">{{ __('Edit Item') }}</h3>
                </div>
                <div class="card-body bg-white">
                    <form method="POST" action="{{ route('tech-creativity.update', $item) }}" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>{{ __('Type') }}</label>
                                <select name="type" class="form-control" required>
                                    <option value="banner" {{ $item->type==='banner'?'selected':'' }}>Banner</option>
                                    <option value="category" {{ $item->type==='category'?'selected':'' }}>Category</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Image Direction') }}</label>
                                <select name="image_direction" class="form-control" required>
                                    <option value="left" {{ $item->image_direction==='left'?'selected':'' }}>Left</option>
                                    <option value="right" {{ $item->image_direction==='right'?'selected':'' }}>Right</option>
                                    <option value="center" {{ $item->image_direction==='center'?'selected':'' }}>Center</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Current Order') }}</label>
                                <input type="number" class="form-control" value="{{ $item->order }}" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>{{ __('Title (EN)') }}</label>
                                <input type="text" name="title_en" class="form-control" value="{{ $item->title_en }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Title (AR)') }}</label>
                                <input type="text" name="title_ar" class="form-control" value="{{ $item->title_ar }}" dir="rtl">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Description (EN)') }}</label>
                            <textarea name="description_en" class="form-control" rows="4" >{{ $item->description_en }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Description (AR)') }}</label>
                            <textarea name="description_ar" class="form-control" rows="4" dir="rtl" >{{ $item->description_ar }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Cover Image') }}</label>
                            <input type="file" name="cover_image" class="form-control-file" accept="image/*">
                            @if($item->cover_image)
                                <div class="mt-2">
                                    <img src="{{ asset($item->cover_image) }}" style="max-width:120px" class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                        <a href="{{ route('tech-creativity.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
