@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('sector Management'),
        'description' => __('Here you can manage your sector vehicles.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('sector Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('sectors.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New Vehicle') }}
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="sectorTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Created At') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectors as $sector)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($sector->cover_image) }}" alt="{{ $sector->title }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $sector->title_en }}</td>
                                            <td>{{ Str::limit($sector->description_en, 50) }}</td>
                                            <td>{{ $sector->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('sectors.edit', $sector) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('sectors.show', $sector) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('Show') }}
                                                </a>
                                                <form action="{{ route('sectors.destroy', $sector) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        {{ __('Delete') }}
                                                    </button>
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
        AOS.init();
    </script>
    <script>
        new DataTable("#sectorTable")
    </script>
@endpush
