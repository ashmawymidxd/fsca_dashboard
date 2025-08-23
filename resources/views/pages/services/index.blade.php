@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Services Management'),
        'description' => __('Here you can manage your services. Drag and drop to reorder.'),
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
                                    <i class="fas fa-plus"></i> {{ __('Add New') }}
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="completeServicesTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('English Title') }}</th>
                                        <th scope="col">{{ __('Arabic Title') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($services as $service)
                                        <tr data-id="{{ $service->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                <img src="{{ asset($service->image_path) }}" alt="{{ $service->title_en }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $service->title_en }}</td>
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
                                                <a href="{{ route('complete_services.edit', $service) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('complete_services.show', $service) }}"
                                                    class="btn btn-sm btn-info">
                                                    {{ __('Show') }}
                                                </a>
                                                <form action="{{ route('complete_services.destroy', $service) }}"
                                                    method="POST" style="display: inline;">
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

        #sortable tr.sortable-ghost {
            opacity: 0.5;
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
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-selected',
                onEnd: function() {
                    // Get the new order
                    const rows = $('#sortable tr');
                    const order = [];

                    rows.each(function(index) {
                        order.push($(this).data('id'));
                    });

                    // Send AJAX request to update order
                    $.ajax({
                        url: "{{ route('complete_services.reorder') }}",
                        type: 'POST',
                        data: {
                            services: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update order numbers in the UI
                                rows.each(function(index) {
                                    $(this).find('.badge').text(index + 1);
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

            // Initialize DataTable but disable sorting on the first column
            $('#completeServicesTable').DataTable({
                columnDefs: [
                    { orderable: false, targets: [0, 6] } // Disable sorting on order and actions columns
                ],
                order: [[0, 'asc']] // Order by the order column initially
            });
        });
    </script>
@endpush
