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
                                        <th scope="col">Cover</th>
                                        <th scope="col">Title (EN)</th>
                                        <th scope="col">Title (AR)</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
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

@push('js')
    <script>
        new DataTable('#projectsTable');
    </script>
@endpush
