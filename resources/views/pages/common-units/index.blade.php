@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Common Units'),
        'description' => __('Here you can manage your common units.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Common Units') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('common-units.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add Common Unit') }}
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
                            <table class="table align-items-center table-flush mt-3 w-100" id="commonTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Banner Image') }}</th>
                                        <th scope="col">{{ __('Cover Image') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commonUnits as $commonUnit)
                                        <tr>
                                            <td>{{ $commonUnit->title_en }}</td>
                                            <td>{{ $commonUnit->title_ar }}</td>
                                            <td>
                                                <img src="{{ asset($commonUnit->banner_image) }}" width="50"
                                                    height="50" alt="Banner">
                                            </td>
                                            <td>
                                                <img src="{{ asset($commonUnit->cover_image) }}" width="50"
                                                    height="50" alt="Cover">
                                            </td>
                                            <td>
                                                <a href="{{ route('common-units.edit', $commonUnit) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('common-units.show', $commonUnit) }}"
                                                    class="btn btn-sm btn-primary">
                                                    {{ __('Show') }}
                                                </a>
                                                <form action="{{ route('common-units.destroy', $commonUnit) }}"
                                                    method="POST" style="display: inline;">
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
        AOS.init()
    </script>

    <script>
        new DataTable("#commonTable")
    </script>
@endpush
