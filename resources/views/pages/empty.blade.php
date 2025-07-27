@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Projects'),
        'description' => __('Here you can manage your projects and view the progress of your work.'),
        'class' => 'col-lg-7',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <h3 class="mb-0">{{ __('Projects Overview') }}</h3>
                    </div>
                    <div class="card-body">
                        hi
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
@endpush
