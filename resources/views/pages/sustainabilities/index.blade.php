@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Sustainability'),
        'description' => __('Here you can manage your sustainability initiatives.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Sustainability Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sustainabilities.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add Sustainability') }}
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
                            <table class="table align-items-center table-flush w-100 mt-3" id="sustainabilitiesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">Cover</th>
                                        <th scope="col">Title (EN)</th>
                                        <th scope="col">Title (AR)</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($sustainabilities as $sustainability)
                                        <tr data-id="{{ $sustainability->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                <img src="{{ asset($sustainability->cover_image) }}" width="50"
                                                    height="50" class="rounded">
                                            </td>
                                            <td>{{ $sustainability->translation('en')->title ?? 'N/A' }}</td>
                                            <td>{{ $sustainability->translation('ar')->title ?? 'N/A' }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $sustainability->is_active ? 'success' : 'danger' }}">
                                                    {{ $sustainability->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('sustainabilities.show', $sustainability) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('sustainabilities.edit', $sustainability) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('sustainabilities.destroy', $sustainability) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
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
                        url: "{{ route('sustainabilities.reorder') }}",
                        type: 'POST',
                        data: {
                            sustainabilities: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update the order numbers displayed
                                rows.each(function(index) {
                                    $(this).find('.sortable-handle small').text('#' + (index + 1));
                                });

                                // Show success message
                                toastr.success('Order updated successfully');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Error updating order');
                        }
                    });
                }
            });

            // Initialize DataTables but disable sorting on the first column (order handle)
            $('#sustainabilitiesTable').DataTable({
                columnDefs: [
                    { orderable: false, targets: [0, 5] } // Disable sorting on order and actions columns
                ],
                order: [[1, 'asc']] // Default sort by the second column (cover image)
            });

        });
    </script>
@endpush
