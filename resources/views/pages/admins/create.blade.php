@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Administrator Management'),
        'description' => __('Create new administrator accounts with specific permissions'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-xl-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('Create New Administrator') }}</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('admins.index') }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="POST" enctype="multipart/form-data" action="{{ route('admins.store') }}"
                            id="admin-create-form">
                            @csrf

                            <div class="pl-lg-4">
                                <h6 class="heading-small text-muted mb-4">{{ __('User Information') }}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="name">{{ __('Full Name') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                                </div>
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name"
                                                    placeholder="{{ __('Full Name') }}">
                                            </div>
                                            @error('name')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="email">{{ __('Email Address') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                </div>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email"
                                                    placeholder="{{ __('Email Address') }}">
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
                                    <div class="col-md-12">
                                        <div class="">
                                            <label class="form-control-label"
                                                for="">{{ __(' Profile Image') }}</label>
                                            <input type="file" id="profile_img" name="profile_image" hidden>
                                            <label for="profile_img"
                                                class="text-start border rounded bg-white shadow-sm w-100 p-2 input-group-text">
                                                <i class="ni ni-album-2"></i> <span class="mx-2">{{ __('Profile Img') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="password">{{ __('Password') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password"
                                                    placeholder="{{ __('Password') }}">
                                            </div>
                                            <small class="form-text text-muted">
                                                {{ __('Minimum 8 characters with at least one uppercase, one lowercase, one number and one special character') }}
                                            </small>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="password-confirm">{{ __('Confirm Password') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-lock-circle-open"></i></span>
                                                </div>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password"
                                                    placeholder="{{ __('Confirm Password') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <hr class="my-4">

                            <div class="pl-lg-4">
                                <h6 class="heading-small text-muted mb-4">{{ __('Administrator Permissions') }}</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            {{ __('Select the permissions you want to grant to this administrator') }}
                                        </div>

                                        <div class="row">
                                            @foreach ($permissions->chunk(ceil($permissions->count() / 3)) as $chunk)
                                                <div class="col-md-4">
                                                    @foreach ($chunk as $permission)
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input class="custom-control-input" type="checkbox"
                                                                name="permissions[]" value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}">
                                                            <label class="custom-control-label"
                                                                for="permission_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus mr-2"></i> {{ __('Create Administrator') }}
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo mr-2"></i> {{ __('Reset Form') }}
                                </button>
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
        // Password strength validation
        document.getElementById('admin-create-form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordRegex.test(password)) {
                e.preventDefault();
                alert(
                    'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                );
            }
        });
    </script>
@endpush
