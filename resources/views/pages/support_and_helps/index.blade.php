@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Support & Help'),
        'description' => __('Here you can manage all support and help items.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Support & Help Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('support-and-helps.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New') }}
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
                            <table class="table align-items-center table-flush w-100 mt-3" id="supportTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" width="50">{{ __('Order') }}</th>
                                        <th scope="col">{{ __('Cover') }}</th>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($supportAndHelps as $item)
                                        <tr data-id="{{ $item->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                <img src="{{ asset($item->cover_image) }}" width="50" height="50"
                                                    class="rounded">
                                            </td>
                                            <td>{{ $item->translation('en')->title ?? 'N/A' }}</td>
                                            <td>{{ $item->translation('ar')->title ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $item->is_active ? 'success' : 'danger' }}">
                                                    {{ $item->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('support-and-helps.show', $item) }}"
                                                    class="btn btn-sm btn-info">{{ __('View') }}</a>
                                                <a href="{{ route('support-and-helps.edit', $item) }}"
                                                    class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                                <form action="{{ route('support-and-helps.destroy', $item) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .alert-info {
            margin-bottom: 20px;
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
                        url: "{{ route('support-and-helps.reorder') }}",
                        type: 'POST',
                        data: {
                            items: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Update order numbers in the table
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
        });
    </script>
@endpush
