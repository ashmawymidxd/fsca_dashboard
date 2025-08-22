@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Projects'),
        'description' => __('Here you can manage your projects and view the progress of your work.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Projects Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add Project') }}
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
                            <table class="table align-items-center table-flush w-100 mt-3" id="projectsTable">
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
                                    @foreach ($projects as $project)
                                        <tr data-id="{{ $project->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                <img src="{{ asset($project->cover_image) }}" width="50" height="50"
                                                    class="rounded">
                                            </td>
                                            <td>{{ $project->translation('en')->title ?? 'N/A' }}</td>
                                            <td>{{ $project->translation('ar')->title ?? 'N/A' }}</td>

                                            <td>
                                                <span class="badge badge-{{ $project->is_active ? 'success' : 'danger' }}">
                                                    {{ $project->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('projects.show', $project) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('projects.edit', $project) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                    style="display: inline;">
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

    <script>
        // Initialize sortable
        $(document).ready(function() {
            new DataTable('#projectsTable');

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
                        url: "{{ route('projects.reorder') }}",
                        type: 'POST',
                        data: {
                            projects: order,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                // Optional: Show a success message
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
