@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('About Us Management'),
        'description' => __('Here you can manage your About Us sections'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('About Us Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('about-us.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New Section') }}
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="aboutTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col" width="120">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($aboutUs as $about)
                                        <tr data-id="{{ $about->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                @if ($about->cover_image)
                                                    <img src="{{ asset($about->cover_image) }}"
                                                        alt="{{ $about->title_en }}" class="img-thumbnail"
                                                        style="max-width: 100px;">
                                                @endif
                                            </td>
                                            <td>{{ $about->title_en }}</td>
                                            <td>{{ Str::limit($about->description_en, 50) }}</td>
                                            <td>{{ $about->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('about-us.show', $about) }}"
                                                        class="btn btn-sm btn-info mr-2" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('about-us.edit', $about) }}"
                                                        class="btn btn-sm btn-primary mr-2" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('about-us.destroy', $about) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this ?');">
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

@push('css')
    <style>
        .sortable-handle {
            cursor: move;
            cursor: -webkit-grabbing;
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
            // Make table rows sortable
            const sortable = new Sortable(document.getElementById('sortable'), {
                handle: '.sortable-handle',
                animation: 150,
                onEnd: function() {
                    const rows = $('#sortable tr');
                    const order = [];

                    rows.each(function(index) {
                        order.push($(this).data('id'));
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: "{{ route('about-us.reorder') }}",
                        type: 'POST',
                        data: {
                            about_us: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Order updated successfully');
                            }
                        },
                        error: function() {
                            toastr.error('Error updating order');
                            location.reload();
                        }
                    });
                }
            });

            // Initialize DataTable
            new DataTable("#aboutTable");
        });
    </script>
@endpush
