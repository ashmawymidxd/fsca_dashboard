@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Policy / Term'),
        'description' => __('Update policy or term information'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body bg-white">
                        <form action="{{ route('policy-terms.update', $policyTerm) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Title (EN)</label>
                                <input type="text" name="title_en" value="{{ $policyTerm->title_en }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Title (AR)</label>
                                <input type="text" name="title_ar" value="{{ $policyTerm->title_ar }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description (EN)</label>
                                <textarea name="description_en" class="form-control" rows="3" required>{{ $policyTerm->description_en }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Description (AR)</label>
                                <textarea name="description_ar" class="form-control" rows="3" required>{{ $policyTerm->description_ar }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="banner" {{ $policyTerm->type == 'banner' ? 'selected' : '' }}>Banner</option>
                                    <option value="category" {{ $policyTerm->type == 'category' ? 'selected' : '' }}>Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cover Image</label><br>
                                @if ($policyTerm->cover_image)
                                    <img src="{{ asset($policyTerm->cover_image) }}" alt="cover"
                                         class="img-thumbnail mb-2" style="max-width: 150px;">
                                @endif
                                <input type="file" name="cover_image" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('policy-terms.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
