@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Banner Management'),
        'description' => __('Manage all your banners here'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ __('Banners Overview') }}</h3>
                        <a href="{{ route('banners.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> {{ __('Add New') }}
                        </a>
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="bannerTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col" width="120">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($banners as $banner)
                                        <tr data-id="{{ $banner->id }}">
                                            <td class="sortable-handle text-center"><i class="fas fa-arrows-alt-v"></i></td>
                                            <td>
                                                <img src="{{ asset($banner->cover_image) }}" alt="{{ $banner->title_en }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $banner->title_en }}</td>
                                            <td>{{ Str::limit($banner->description_en, 50) }}</td>
                                            <td>
                                                @if ($banner->status == 'active')
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
                                                    <a href="{{ route('banners.show', $banner) }}"
                                                        class="btn btn-sm btn-info mr-2"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('banners.edit', $banner) }}"
                                                        class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('banners.destroy', $banner) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i
                                                                class="fas fa-trash"></i></button>
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

@push('css')
    <style>
        .sortable-handle {
            cursor: move;
            cursor: -webkit-grabbing;
        }

        #sortable tr {
            cursor: move;
        }

        #sortable tr.sortable-selected {
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            const sortable = new Sortable(document.getElementById('sortable'), {
                handle: '.sortable-handle',
                animation: 150,
                onEnd: function() {
                    const rows = $('#sortable tr'),
                        order = [];
                    rows.each(function() {
                        order.push($(this).data('id'));
                    });
                    $.post("{{ route('banners.reorder') }}", {
                        banners: order,
                        _token: "{{ csrf_token() }}"
                    }, function(response) {
                        if (response.success) {
                            toastr.success('Order updated');
                        }
                    }).fail(() => {
                        toastr.error('Error updating order');
                        location.reload();
                    });
                }
            });
            new DataTable("#bannerTable");
        });
    </script>
@endpush
