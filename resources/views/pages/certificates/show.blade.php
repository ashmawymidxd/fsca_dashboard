@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Certificate Details') . ' - ' . $certificate->title_en,
        'description' => __('View certificate information'),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Certificate Information') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('certificates.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <img src="{{ asset($certificate->cover_image) }}" alt="{{ $certificate->title_en }}" class="img-fluid rounded shadow">
                            </div>
                            <div class="col-md-8">
                                <h4>{{ __('Certificate Details') }}</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">{{ __('Order') }}</th>
                                        <td>{{ $certificate->order }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Created At') }}</th>
                                        <td>{{ $certificate->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Updated At') }}</th>
                                        <td>{{ $certificate->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('English Version') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <h4>{{ $certificate->title_en }}</h4>
                                        <p>{{ $certificate->description_en }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('Arabic Version') }}</h5>
                                    </div>
                                    <div class="card-body" dir="rtl">
                                        <h4>{{ $certificate->title_ar }}</h4>
                                        <p>{{ $certificate->description_ar }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('certificates.edit', $certificate) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> {{ __('Edit Certificate') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
