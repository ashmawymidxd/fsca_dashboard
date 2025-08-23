@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Tech Creativity Details'),
        'description' => __('View full details about this creativity record'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow border-0">
                    <!-- Header -->
                    <div class="card-header text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-lightbulb mr-2"></i> Tech Creativity
                        </h3>
                        <a href="{{ route('tech-creativity.index') }}" class="btn btn-light btn-sm shadow-sm">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Left Column: Image -->
                            <div class="col-md-4 text-center mb-4">
                                <img src="{{ asset($tech_creativity->cover_image) }}"
                                     alt="Cover Image"
                                     class="img-fluid rounded shadow-sm mb-3"
                                     style="max-height: 280px; object-fit: cover;">

                                <span class="badge badge-info px-3 py-2">
                                    <i class="fas fa-layer-group"></i> {{ ucfirst($tech_creativity->type) }}
                                </span>
                                <span class="badge badge-secondary px-3 py-2">
                                    <i class="fas fa-arrows-alt-h"></i> {{ ucfirst($tech_creativity->image_direction) }}
                                </span>
                            </div>

                            <!-- Right Column: Details -->
                            <div class="col-md-8">
                                <dl class="row">
                                    <dt class="col-sm-4 text-muted">Main Header (EN)</dt>
                                    <dd class="col-sm-8 font-weight-bold">{{ $tech_creativity->title_en }}</dd>

                                    <dt class="col-sm-4 text-muted">Main Header (AR)</dt>
                                    <dd class="col-sm-8 font-weight-bold">{{ $tech_creativity->title_ar }}</dd>

                                    <dt class="col-sm-4 text-muted">Description (EN)</dt>
                                    <dd class="col-sm-8">{{ $tech_creativity->description_en }}</dd>

                                    <dt class="col-sm-4 text-muted">Description (AR)</dt>
                                    <dd class="col-sm-8">{{ $tech_creativity->description_ar }}</dd>

                                    <dt class="col-sm-4 text-muted">Created At</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge badge-success">
                                            {{ $tech_creativity->created_at->format('d M Y, h:i A') }}
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4 text-muted">Updated At</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge badge-warning">
                                            {{ $tech_creativity->updated_at->format('d M Y, h:i A') }}
                                        </span>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('tech-creativity.edit', $tech_creativity->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('tech-creativity.destroy', $tech_creativity->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
