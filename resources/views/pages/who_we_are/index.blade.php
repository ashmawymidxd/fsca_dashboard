@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Who We Are'),
        'description' => __('Here you can manage Who We Are content.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Who We Are Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('who_we_are.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="WhoWeAreTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($whoWeAres as $whoWeAre)
                                        <tr data-id="{{ $whoWeAre->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>{{ $whoWeAre->title_en }}</td>
                                            <td>{{ $whoWeAre->title_ar }}</td>
                                            <td>
                                                @if ($whoWeAre->cover_image)
                                                    <img src="{{ asset($whoWeAre->cover_image) }}" width="100" alt="Cover Image">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('who_we_are.show', $whoWeAre) }}" class="btn btn-sm btn-info mr-2">
                                                        {{ __('View') }}
                                                    </a>
                                                    <a href="{{ route('who_we_are.edit', $whoWeAre) }}" class="btn btn-sm btn-primary mr-2">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('who_we_are.destroy', $whoWeAre) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry?')">
                                                            {{ __('Delete') }}
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

        #sortable tr {
            cursor: move;
        }

        #sortable tr.sortable-selected {
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        // Initialize sortable
        $(document).ready(function() {
            // Make table rows sortable
            const sortable = new Sortable(document.getElementById('sortable'), {
                handle: '.sortable-handle',
                animation: 150,
                onEnd: function() {
                    // Get the new order
                    const rows = $('#sortable tr');
                    const order = [];

                    rows.each(function(index) {
                        order.push($(this).data('id'));
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: "{{ route('who_we_are.reorder') }}",
                        type: 'POST',
                        data: {
                            who_we_ares: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                toastr.success('Order updated successfully');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error updating order');
                            // Reload the page to reset the order
                            location.reload();
                        }
                    });
                }
            });

            // Initialize DataTable but disable sorting on the first column
            new DataTable("#WhoWeAreTable", {
                columnDefs: [
                    { orderable: false, targets: [0, 3, 4] } // Disable sorting for Order, Image, and Actions columns
                ]
            });
        });
    </script>
@endpush
