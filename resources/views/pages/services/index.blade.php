@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Services Management'),
        'description' => __('Here you can manage your services.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Services Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('complete_services.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New Service') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-whit">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="completeServicesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('English Title') }}</th>
                                        <th scope="col">{{ __('Arabic Title') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($service->image_path) }}" alt="{{ $service->title }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $service->title_ar }}</td>
                                            <td>{{ $service->title_ar }}</td>
                                            <td>{{ $service->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($service->status == 'active')
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle mr-1"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('complete_services.show', $service) }}"
                                                        class="btn btn-sm btn-info mr-2" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('complete_services.edit', $service) }}"
                                                        class="btn btn-sm btn-primary mr-2" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('complete_services.destroy', $service) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        new DataTable("#completeServicesTable")
    </script>
@endpush
