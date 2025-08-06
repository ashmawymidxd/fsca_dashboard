@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Adminstrators'),
        'description' => __('Here you can manage your Adminstrators.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6">
        <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col">
                <div class="card p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="card-title">Admins Management</h2>
                        @if (auth()->user()->hasPermission('manage-admins') || auth()->user()->is_super_admin)
                            <a href="{{ route('admins.create') }}" class="btn btn-primary float-right">Add Admin</a>
                        @endif
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush w-100 mt-3" id="AdminstratorsTabele">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->id }}-SFCL</td>
                                        <td>
                                            <img src="{{ asset('assets/profile_images/' . $admin->profile_image) }}"
                                                class="rounded-circle shadow-lg border-white border-4"
                                                style="width: 50px; height: 50px; object-fit: cover;"
                                                alt="{{ $admin->name }} profile image">
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($admin->permissions as $permission)
                                                    <span class="badge badge-primary m-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admins.show', $admin->id) }}"
                                                class="btn btn-info btn-sm">View</a>
                                            @if (auth('web')->user()->hasPermission('manage-admins') || auth('web')->user()->is_super_admin)
                                                <a href="{{ route('admins.edit', $admin->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                                </form>
                                            @endif
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
@endsection

@push('js')
    <script>
        new DataTable("#AdminstratorsTabele")
    </script>
@endpush
