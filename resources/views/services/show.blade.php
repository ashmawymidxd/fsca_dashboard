@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Service Details'),
        'description' => __('View detailed information about this service'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <!-- Card Header with Breadcrumb Navigation -->
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-links bg-transparent p-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('services.index') }}">
                                                <i class="fas fa-home"></i> {{ __('Services') }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            {{ $service->title_en }}
                                        </li>
                                    </ol>
                                </nav>
                                <h3 class="mb-0 mt-2">{{ $service->title_en }}</h3>
                                @if ($service->title_ar)
                                    <p class="text-muted mb-0">{{ $service->title_ar }}</p>
                                @endif
                            </div>
                            <div class="col-4 text-right">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#shareModal">
                                            <i class="fas fa-share-alt"></i> {{ __('Share') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('services.destroy', $service) }}" method="POST"
                                            class="dropdown-item p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger"
                                                onclick="return confirm('Are you sure you want to delete this service?')">
                                                <i class="fas fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <!-- Service Details Section -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="card card-lift--hover shadow border-0">
                                    <img src="{{ url($service->cover_image) }}" class="card-img-top rounded"
                                        alt="{{ $service->title_en }}">
                                    <div class="card-body text-center">
                                        <h5 class="h3 card-title mb-0">{{ $service->title_en }}</h5>
                                        @if ($service->title_ar)
                                            <p class="text-muted mt-1">{{ $service->title_ar }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content" id="serviceDescriptionTabs">
                                    <div class="tab-pane fade show active" id="english" role="tabpanel"
                                        aria-labelledby="english-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4>{{ __('English Version') }}</h4>
                                            <span class="badge badge-pill badge-primary">EN</span>
                                        </div>
                                        <div class="description-content bg-white border p-4 rounded shadow-sm">
                                            {!! nl2br(e($service->description_en)) !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4>{{ __('Arabic Version') }}</h4>
                                            <span class="badge badge-pill badge-primary">AR</span>
                                        </div>
                                        <div class="description-content bg-white border p-4 rounded shadow-sm"
                                            dir="rtl">
                                            {!! nl2br(e($service->description_ar)) !!}
                                        </div>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs mt-4" id="descriptionTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english"
                                            role="tab" aria-controls="english" aria-selected="true">
                                            {{ __('English') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab"
                                            aria-controls="arabic" aria-selected="false">
                                            {{ __('Arabic') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Categories Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-0">{{ __('Categories') }}</h4>
                                <p class="text-muted mb-0">{{ __('Manage service categories and subcategories') }}</p>
                            </div>
                            <a href="{{ route('services.categories.create', $service) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> {{ __('Add Category') }}
                            </a>
                        </div>

                        @if ($service->categories->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush table-hover w-100 mt-3" id="showTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" width="5%">{{ __('Order') }}</th>
                                            <th scope="col" width="15%">{{ __('Type') }}</th>
                                            <th scope="col">{{ __('Main Header') }}</th>
                                            <th scope="col" width="10%">{{ __('Image') }}</th>
                                            <th scope="col" width="25%">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @foreach ($service->categories->sortBy('order') as $category)
                                            <tr data-id="{{ $category->id }}">
                                                <td class="sortable-handle text-center" style="cursor: move;">
                                                    <i class="fas fa-arrows-alt-v"></i>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $category->type == 'category' ? 'info' : 'warning' }}">
                                                        {{ ucfirst($category->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold">{{ $category->main_header_en }}</div>
                                                    @if ($category->main_header_ar)
                                                        <div class="small text-muted">{{ $category->main_header_ar }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="avatar-group">
                                                        <a href="#" class="" data-toggle="tooltip"
                                                            data-original-title="{{ $category->main_header_en }}">
                                                            <img width="100" class="rounded" alt="Image placeholder"
                                                                src="{{ url($category->cover_image) }}">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('services.categories.show', [$service, $category]) }}"
                                                            class="btn btn-sm btn-info mr-2" data-toggle="tooltip"
                                                            title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('services.categories.edit', [$service, $category]) }}"
                                                            class="btn btn-sm btn-warning mr-2" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('services.categories.destroy', [$service, $category]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure?')"
                                                                data-toggle="tooltip" title="Delete">
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
                        @else
                            <div class="card bg-gradient-default shadow">
                                <div class="card-body text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                    <h4 class="text-muted">{{ __('No Categories Found') }}</h4>
                                    <p class="text-muted">{{ __('This service doesn\'t have any categories yet.') }}</p>
                                    <a href="{{ route('services.categories.create', $service) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> {{ __('Create First Category') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shareModalLabel">{{ __('Share Service') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shareLink">{{ __('Shareable Link') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="shareLink" value="{{ url()->current() }}"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" onclick="copyShareLink()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="social-share mt-4 text-center">
                        <a href="#" class="btn btn-icon-only btn-rounded btn-facebook mx-1">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-icon-only btn-rounded btn-twitter mx-1">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-icon-only btn-rounded btn-linkedin mx-1">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="btn btn-icon-only btn-rounded btn-whatsapp mx-1">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>

    <script>
        function copyShareLink() {
            const copyText = document.getElementById("shareLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");

            // Show tooltip or alert
            alert("Link copied to clipboard!");
        }

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Initialize DataTable
        $(document).ready(function() {
            new DataTable("#showTable", {
                // Disable sorting for the first and last columns (order and actions)
                columnDefs: [{
                    orderable: false,
                    targets: [0, 4]
                }]
            });

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
                        url: "{{ route('services.categories.reorder', $service) }}",
                        type: 'POST',
                        data: {
                            categories: order,
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

@push('css')
    <style>
        .description-content {
            min-height: 150px;
            max-height: 300px;
            overflow-y: auto;
        }

        .nav-tabs .nav-link.active {
            font-weight: 600;
            border-bottom: 2px solid #5e72e4;
        }

        .card-lift--hover:hover {
            transform: translateY(-5px);
            transition: all .15s ease;
        }

        .social-share a {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Sortable styles */
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
