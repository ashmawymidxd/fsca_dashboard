@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Blog Management'),
        'description' => __('Here you can manage your blogs'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Blog Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="blogTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50">{{ __('Order') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th width="120">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($blogs as $blog)
                                        <tr data-id="{{ $blog->id }}">
                                            <td class="sortable-handle text-center"><i class="fas fa-arrows-alt-v"></i></td>
                                            <td>
                                                <img src="{{ asset($blog->cover_image) }}" alt="{{ $blog->title_en }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $blog->title_en }}</td>
                                            <td>{{ Str::limit($blog->description_en, 50) }}</td>
                                            <td>
                                                @if ($blog->status == 'active')
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
                                                    <a href="{{ route('blogs.show', $blog) }}"
                                                        class="btn btn-sm btn-info mr-2"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('blogs.edit', $blog) }}"
                                                        class="btn btn-sm btn-primary mr-2"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('blogs.destroy', $blog) }}" method="POST"
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
                    const rows = $('#sortable tr');
                    const order = [];
                    rows.each(function() {
                        order.push($(this).data('id'));
                    });
                    $.post("{{ route('blogs.reorder') }}", {
                        blogs: order,
                        _token: "{{ csrf_token() }}"
                    }, function(res) {
                        if (res.success) toastr.success('Order updated successfully');
                    }).fail(function() {
                        toastr.error('Error updating order');
                        location.reload();
                    });
                }
            });
            new DataTable("#blogTable");
        });
    </script>
@endpush
