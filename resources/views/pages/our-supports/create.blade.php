@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Create New Support'),
        'description' => __('Add a new support item to your collection'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        @php
            $formTitle = 'Create Support';
            $formAction = route('our-supports.store');
        @endphp

        @include('pages.our-supports.form')

        @include('layouts.footers.auth')
    </div>
@endsection
