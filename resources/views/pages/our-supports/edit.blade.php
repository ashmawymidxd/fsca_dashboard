@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Edit Support'),
        'description' => __('Update the support item'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        @php
            $formTitle = 'Edit Support';
            $formAction = route('our-supports.update', $support);
        @endphp

        @include('pages.our-supports.form')

        @include('layouts.footers.auth')

    </div>
@endsection
