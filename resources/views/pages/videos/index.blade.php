@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Video Management'),
        'description' => __('Here you can manage your videos.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Videos') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                @if ($videos->count() == 0)
                                    <a href="{{ route('videos.create') }}" class="btn btn-sm btn-primary">
                                        {{ __('Upload Video') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="videoTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Uploaded At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td>{{ $video->title }}</td>
                                            <td>{{ $video->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('videos.show', $video->id) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('videos.edit', $video->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('videos.destroy', $video->id) }}" method="POST"
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
                        <div class="mt-4">
                            {{ $videos->links() }}
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
        AOS.init()
    </script>
    <script>
        new DataTable("#videoTable")
    </script>
@endpush
