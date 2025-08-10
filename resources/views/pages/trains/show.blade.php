@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('train Vehicle Details'),
        'description' => __('View detailed information about this vehicle.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Vehicle Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('trains.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{ asset($train->cover_image) }}" class="card-img-top" alt="{{ $train->title }}">
                                    <div class="card-body bg-white">
                                        <h5 class="card-title">{{ $train->title }}</h5>
                                        <p class="card-text">{{ $train->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="width: 30%">{{ __('English Title') }}</th>
                                                <td>{{ $train->title_en }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Arabic Title') }}</th>
                                                <td>{{ $train->title_ar }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('English Description') }}</th>
                                                <td>{{ $train->description_en }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Arabic Description') }}</th>
                                                <td>{{ $train->description_ar }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Created At') }}</th>
                                                <td>{{ $train->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Updated At') }}</th>
                                                <td>{{ $train->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('trains.edit', $train) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('trains.destroy', $train) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
