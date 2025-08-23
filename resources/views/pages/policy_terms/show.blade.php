@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Policy / Term Details'),
        'description' => __('View detailed information'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body bg-white">
                        <h3>{{ $policyTerm->title_en }} <small class="text-muted">({{ $policyTerm->title_ar }})</small></h3>
                        <p><strong>Type:</strong> {{ ucfirst($policyTerm->type) }}</p>
                        <p><strong>Description EN:</strong><br>{{ $policyTerm->description_en }}</p>
                        <p><strong>Description AR:</strong><br>{{ $policyTerm->description_ar }}</p>
                        @if ($policyTerm->cover_image)
                            <p><strong>Image:</strong></p>
                            <img src="{{ asset($policyTerm->cover_image) }}" alt="cover" class="img-thumbnail" style="max-width: 200px;">
                        @endif
                        <hr>
                        <a href="{{ route('policy-terms.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('policy-terms.edit', $policyTerm) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
