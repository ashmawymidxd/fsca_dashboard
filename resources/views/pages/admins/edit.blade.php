@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Administrator'),
        'description' => __('Update administrator account details and permissions'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('Edit Administrator') }}</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('admins.show', $admin->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye mr-1"></i> {{ __('View Profile') }}
                                </a>
                                <a href="{{ route('admins.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admins.update', $admin->id) }}" id="admin-edit-form">
                            @csrf
                            @method('PUT')

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">{{ __('Full Name') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                                </div>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                    name="name" value="{{ old('name', $admin->name) }}" required autocomplete="name">
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">{{ __('Email Address') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                </div>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email', $admin->email) }}" required autocomplete="email">
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="password">{{ __('New Password') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Leave blank to keep current password. Minimum 8 characters with at least one uppercase, one lowercase, one number and one special character') }}
                                            </small>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="form-group">
                                    <label class="form-control-label">{{ __('Permissions') }}</label>
                                    <div class="alert alert-info alert-dismissible fade show">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        {{ __('Select the permissions you want to grant to this administrator') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="row">
                                        @foreach ($permissions->chunk(ceil($permissions->count()/3)) as $chunk)
                                            <div class="col-md-4">
                                                @foreach ($chunk as $permission)
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input class="custom-control-input" type="checkbox"
                                                            name="permissions[]" value="{{ $permission->id }}"
                                                            id="permission_{{ $permission->id }}"
                                                            {{ $admin->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save mr-2"></i> {{ __('Update Administrator') }}
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo mr-2"></i> {{ __('Reset Changes') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Password toggle visibility
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                const input = $(this).closest('.input-group').find('input');
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength validation
            $('#admin-edit-form').submit(function(e) {
                const password = $('#password').val();
                if (password.length > 0) {
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                    if (!passwordRegex.test(password)) {
                        e.preventDefault();
                        alert('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
                    }
                }
            });
        });
    </script>
@endpush

@push('css')
    <style>
        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #fb6340;
            border-color: #fb6340;
        }
        .toggle-password:hover {
            background-color: #f6f9fc;
        }
    </style>
@endpush
