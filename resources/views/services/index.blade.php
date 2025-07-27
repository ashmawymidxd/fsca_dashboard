@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Services'),
        'description' => __('Here you can manage your services and their categories.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Services Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New Service') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush w-100 mt-3" id="servicesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Categories') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ $service->title_en }}</td>
                                            <td>{{ $service->title_ar }}</td>
                                            <td>
                                                <img src="{{ url($service->cover_image) }}" width="100" class="rounded">
                                            </td>
                                            <td>{{ $service->categories->count() }}</td>
                                            <td>
                                                <a href="{{ route('services.show', $service) }}"
                                                    class="btn btn-sm btn-info">
                                                    {{ __('View') }}
                                                </a>
                                                <a href="{{ route('services.edit', $service) }}"
                                                    class="btn btn-sm btn-warning">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('services.categories.index', $service) }}"
                                                    class="btn btn-sm btn-success">
                                                    {{ __('Categories') }}
                                                </a>
                                                <form action="{{ route('services.destroy', $service) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
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
        new DataTable("#servicesTable")
    </script>
@endpush
