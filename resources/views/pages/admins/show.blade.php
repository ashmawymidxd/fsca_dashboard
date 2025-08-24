@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Administrator Details'),
        'description' => __('View administrator account details and permissions'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('Administrator Profile') }}</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('admins.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-5">
                            <div class="avatar-xxl position-relative d-inline-block">
                                <img src="{{ asset('assets/profile_images/' . $admin->profile_image) }}"
                                     class="rounded-circle shadow-lg border-white border-4"
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     alt="{{ $admin->name }} profile image">
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-3 border-white">
                                    <i class="fas fa-user-shield text-white"></i>
                                </span>
                            </div>
                            <h3 class="mt-3 mb-0">{{ $admin->name }}</h3>
                            <p class="text-muted mb-0">{{ $admin->email }}</p>
                            <small class="text-muted">
                                {{ __('Member since') }} {{ $admin->created_at->format('M d, Y') }}
                                ({{ $admin->created_at->diffForHumans() }})
                            </small>
                        </div>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-profile shadow-sm mb-4">
                                        <div class="card-header bg-white border-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="mb-0"><i class="fas fa-id-card mr-2 text-primary"></i> {{ __('Account Information') }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="icon icon-shape bg-gradient-primary rounded-circle text-white mr-3">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('Full Name') }}</h6>
                                                    <p class="text-sm text-muted mb-0">{{ $admin->name }}</p>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center mb-4">
                                                <div class="icon icon-shape bg-gradient-info rounded-circle text-white mr-3">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('Email Address') }}</h6>
                                                    <p class="text-sm text-muted mb-0">{{ $admin->email }}</p>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape bg-gradient-success rounded-circle text-white mr-3">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ __('Account Created') }}</h6>
                                                    <p class="text-sm text-muted mb-0">
                                                        {{ $admin->created_at->format('F j, Y \a\t g:i A') }}
                                                        <br>
                                                        <small>({{ $admin->created_at->diffForHumans() }})</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card card-profile shadow-sm mb-4">
                                        <div class="card-header bg-white border-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h5 class="mb-0"><i class="fas fa-user-shield mr-2 text-warning"></i> {{ __('Permissions') }}</h5>
                                                </div>
                                                <div class="col text-right">
                                                    <span class="badge badge-primary">
                                                        {{ $admin->permissions->count() }} {{ __('Permissions') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if($admin->permissions->count() > 0)
                                                <div class="row">
                                                    @foreach($admin->permissions as $permission)
                                                        <div class="col-md-4 mb-3">
                                                            <div class="card card-stats shadow-none border">
                                                                <div class="card-body p-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="icon icon-shape bg-gradient-{{ $permission->id % 2 ? 'info' : 'success' }} rounded-circle text-white mr-3">
                                                                            <i class="fas fa-check"></i>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0 text-sm">{{ $permission->name }}</h6>
                                                                            <small class="text-muted">{{ __('Granted') }}</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-warning mb-0">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    {{ __('This administrator has no specific permissions assigned.') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('admins.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i> {{ __('Back to List') }}
                                </a>

                                @if (auth('web')->user()->hasPermission('manage-admins') || auth('web')->user()->is_super_admin)
                                    <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit mr-2"></i> {{ __('Edit Administrator') }}
                                    </a>
                                @endif

                                @if (auth('web')->user()->is_super_admin && auth('web')->user()->id !== $admin->id)
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    @if (auth('web')->user()->is_super_admin && auth('web')->user()->id !== $admin->id)
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this administrator? This action cannot be undone.') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Administrator') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('css')
    <style>
        .avatar-xxl {
            width: 150px;
            height: 150px;
            margin: 0 auto;
        }
        .card-profile {
            transition: all 0.3s ease;
        }
        .card-profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .icon-shape {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush
