@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Who We Are'),
        'description' => __('Here you can manage Who We Are content.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Who We Are Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('who_we_are.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New') }}
                                </a>
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="WhoWeAreTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($whoWeAres as $whoWeAre)
                                        <tr>
                                            <td>{{ $whoWeAre->title_en }}</td>
                                            <td>{{ $whoWeAre->title_ar }}</td>
                                            <td>
                                                @if ($whoWeAre->cover_image)
                                                    <img src="{{ asset($whoWeAre->cover_image) }}" width="100" alt="Cover Image">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('who_we_are.show', $whoWeAre) }}" class="btn btn-sm btn-info mr-2">
                                                        {{ __('View') }}
                                                    </a>
                                                    <a href="{{ route('who_we_are.edit', $whoWeAre) }}" class="btn btn-sm btn-primary mr-2">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('who_we_are.destroy', $whoWeAre) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry?')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
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
        AOS.init()
    </script>

    <script>
        new DataTable("#WhoWeAreTable")
    </script>
@endpush
