@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Categories for Service: ') . $service->title_en,
        'description' => __('Manage categories and banners for this service'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Categories Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('services.categories.create', $service) }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New Category') }}
                                </a>
                                <a href="{{ route('services.index') }}" class="btn btn-sm btn-secondary">
                                    {{ __('Back to Services') }}
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

                        <div class="mb-4">
                            <h4>{{ __('Service Information') }}</h4>
                            <div class="d-flex align-items-center">
                                <img src="{{ url($service->cover_image) }}" width="80" class="rounded mr-3">
                                <div>
                                    <h5>{{ $service->title_en }} / {{ $service->title_ar }}</h5>
                                    <p class="mb-0 text-muted">{{ __('Total Categories: ') }} <strong>{{ $service->categories->count() }}</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive bg-white rounded mt-5 p-3 border">
                            <table class="table align-items-center table-flush w-100 mt-3" id="categoriesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Type') }}</th>
                                        <th scope="col">{{ __('Main Header') }}</th>
                                        <th scope="col">{{ __('Sub Header') }}</th>
                                        <th scope="col">{{ __('Focus') }}</th>
                                        <th scope="col" width="150">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>
                                                <img src="{{ url($category->cover_image) }}" width="100" class="rounded">
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $category->type == 'category' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($category->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $category->main_header_en }}</strong><br>
                                                <small class="text-muted">{{ $category->main_header_ar }}</small>
                                            </td>
                                            <td>
                                                {{ $category->sub_header_en }}<br>
                                                <small class="text-muted">{{ $category->sub_header_ar }}</small>
                                            </td>
                                            <td>
                                                {{ $category->focus_en }}<br>
                                                <small class="text-muted">{{ $category->focus_ar }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('services.categories.show', [$service, $category]) }}"
                                                   class="btn btn-sm btn-info"
                                                   title="{{ __('View') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('services.categories.edit', [$service, $category]) }}"
                                                   class="btn btn-sm btn-warning"
                                                   title="{{ __('Edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('services.categories.destroy', [$service, $category]) }}"
                                                      method="POST"
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            title="{{ __('Delete') }}"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <p>
                                            <span colspan="6" class="text-center">
                                                <div class="alert alert-warning mb-0">
                                                    {{ __('No categories found for this service.') }}
                                                </div>
                                            </span>
                                        </p>
                                    @endforelse
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
        // Delete confirmation with SweetAlert
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
    <script>
        new DataTable("#categoriesTable");
    </script>
@endpush
