@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Fleet Management'),
        'description' => __('Here you can manage your fleet vehicles.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Fleet Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('fleets.create') }}" class="btn btn-sm btn-primary">
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="FleetTable">
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
                                    @foreach ($fleets as $fleet)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($fleet->cover_image) }}" alt="{{ $fleet->title }}"
                                                    class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $fleet->title_en }}</td>
                                            <td>{{ Str::limit($fleet->description_en, 50) }}</td>
                                            <td>{{ $fleet->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('fleets.show', $fleet) }}"
                                                        class="btn btn-sm btn-info mr-2" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('fleets.edit', $fleet) }}"
                                                        class="btn btn-sm btn-primary mr-2" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('fleets.destroy', $fleet) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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
        new DataTable("#FleetTable")
    </script>
@endpush
