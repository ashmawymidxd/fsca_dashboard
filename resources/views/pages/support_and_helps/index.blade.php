@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Support & Help'),
        'description' => __('Here you can manage all support and help items.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Support & Help Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('support-and-helps.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add New') }}
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
                            <table class="table align-items-center table-flush w-100 mt-3 " id="supportTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Cover') }}</th>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Status') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supportAndHelps as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->cover_image) }}" width="50" height="50"
                                                    class="rounded">
                                            </td>
                                            <td>{{ $item->translation('en')->title ?? 'N/A' }}</td>
                                            <td>{{ $item->translation('ar')->title ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $item->is_active ? 'success' : 'danger' }}">
                                                    {{ $item->is_active ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('support-and-helps.show', $item) }}"
                                                    class="btn btn-sm btn-info">{{ __('View') }}</a>
                                                <a href="{{ route('support-and-helps.edit', $item) }}"
                                                    class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                                                <form action="{{ route('support-and-helps.destroy', $item) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
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
        new DataTable('#supportTable');
    </script>
@endpush
