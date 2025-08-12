@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Customers'),
        'description' => __('Here you can manage your customers.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Customers') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add Customer') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="customerTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Name (English)') }}</th>
                                        <th scope="col">{{ __('Name (Arabic)') }}</th>
                                        <th scope="col">{{ __('Logo') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->name_en }}</td>
                                            <td>{{ $customer->name_ar }}</td>
                                            <td>
                                                @if ($customer->logo)
                                                    <img src="{{ asset($customer->logo) }}" width="50" height="50"
                                                        class="rounded-circle">
                                                @else
                                                    No Logo
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('customers.edit', $customer) }}"
                                                        class="btn btn-sm btn-primary">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('customers.destroy', $customer) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
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
        new DataTable("#customerTable")
    </script>
@endpush
