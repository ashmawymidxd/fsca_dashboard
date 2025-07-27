@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Category Details: ') . $category->main_header_en,
        'description' => __('View detailed information about this category'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $category->main_header_en }}</h3>
                                <p class="text-muted mb-0">
                                    <span class="badge badge-primary">{{ ucfirst($category->type) }}</span>
                                    <span class="badge badge-info ml-2">{{ $category->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('services.categories.edit', [$service, $category]) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                    </a>
                                    <a href="{{ route('services.categories.index', $service) }}"
                                       class="btn btn-sm btn-default">
                                        <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <!-- Image and Basic Info -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card card-profile shadow">
                                    <img src="{{ url($category->cover_image) }}" class="card-img-top rounded"
                                         alt="{{ $category->main_header_en }}"
                                         style="max-height: 300px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <div class="h5 mt-3">
                                            {{ $category->main_header_en }}
                                        </div>
                                        <div class="h6 font-weight-300 text-muted">
                                            {{ $category->sub_header_en }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <!-- Language Tabs -->
                                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                            <i class="fas fa-language mr-1"></i> English
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                            <i class="fas fa-language mr-1"></i> العربية
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="languageTabsContent">
                                    <!-- English Version -->
                                    <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="pl-3">
                                            <h4 class="text-primary">{{ __('Main Header') }}</h4>
                                            <p class="lead">{{ $category->main_header_en }}</p>

                                            <h4 class="text-primary mt-4">{{ __('Sub Header') }}</h4>
                                            <p>{{ $category->sub_header_en }}</p>

                                            <h4 class="text-primary mt-4">{{ __('Description') }}</h4>
                                            <p class="text-justify">{{ $category->description_en }}</p>

                                            <div class="mt-4">
                                                <h4 class="alert-heading text-primary">{{ __('Focus Area') }}</h4>
                                                <p>{{ $category->focus_en }}</p>
                                            </div>

                                            <div class=" mt-4">
                                                <h4 class="alert-heading text-primary">{{ __('Button Text Area') }}</h4>
                                                <p>{{ $category->button_text_en }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Arabic Version -->
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                        <div class="pl-3" dir="rtl" style="text-align: right;">
                                            <h4 class="text-primary">{{ __('Main Header') }}</h4>
                                            <p class="lead">{{ $category->main_header_ar }}</p>

                                            <h4 class="text-primary mt-4">{{ __('Sub Header') }}</h4>
                                            <p>{{ $category->sub_header_ar }}</p>

                                            <h4 class="text-primary mt-4">{{ __('Description') }}</h4>
                                            <p class="text-justify">{{ $category->description_ar }}</p>

                                            <div class="mt-4">
                                                <h4 class="alert-heading text-primary">{{ __('Focus Area') }}</h4>
                                                <p>{{ $category->focus_ar }}</p>
                                            </div>
                                            <div class="mt-4">
                                                <h4 class="alert-heading text-primary">{{ __('Button Text Area') }}</h4>
                                                <p>{{ $category->button_text_ar }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>{{ __('Metadata') }}</h5>
                                    </div>
                                    <div class="card-body bg-white">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ __('Created At') }}
                                                <span class="badge badge-primary badge-pill">
                                                    {{ $category->created_at->format('M d, Y') }}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ __('Updated At') }}
                                                <span class="badge badge-primary badge-pill">
                                                    {{ $category->updated_at->format('M d, Y') }}
                                                </span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ __('Status') }}
                                                <span class="badge badge-success badge-pill">
                                                    {{ __('Active') }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>{{ __('Actions') }}</h5>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('services.categories.edit', [$service, $category]) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit mr-1"></i> {{ __('Edit') }}
                                            </a>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#previewModal">
                                                <i class="fas fa-eye mr-1"></i> {{ __('Preview') }}
                                            </a>
                                            <a href="{{ route('services.categories.index', $service) }}"
                                               class="btn btn-secondary btn-sm">
                                                <i class="fas fa-list mr-1"></i> {{ __('All Categories') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">
                                {{ __('Last updated: ') }} {{ $category->updated_at->diffForHumans() }}
                            </small>
                            <div>
                                <a href="{{ route('services.categories.index', $service) }}"
                                   class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Categories') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">{{ __('Category Preview') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="{{ url($category->cover_image) }}" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    <h3 class="text-center">{{ $category->main_header_en }}</h3>
                    <p class="text-center text-muted">{{ $category->sub_header_en }}</p>
                    <hr>
                    <p>{{ $category->description_en }}</p>
                    <div class="">
                        <h4 class="alert-heading">{{ __('Focus Area') }}</h4>
                        <p>{{ $category->focus_en }}</p>
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
    <script>
        // Activate Bootstrap tabs
        $(document).ready(function(){
            $('#languageTabs a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
