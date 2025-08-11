@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Hero Sections'),
        'description' => __('Here you can manage your hero sections.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Hero Sections') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('heroes.create') }}" class="btn btn-sm btn-primary">
                                    {{ __('Add Hero') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="heroTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('Title (EN)') }}</th>
                                        <th scope="col">{{ __('Title (AR)') }}</th>
                                        <th scope="col">{{ __('Button Text (EN)') }}</th>
                                        <th scope="col">{{ __('Image') }}</th>
                                        <th scope="col">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($heroes as $hero)
                                        <tr>
                                            <td>{{ $hero->title_en }}</td>
                                            <td>{{ $hero->title_ar }}</td>
                                            <td>{{ $hero->button_text_en }}</td>
                                            <td>
                                                @if($hero->cover_image)
                                                    <img src="{{ asset($hero->cover_image) }}" width="100" alt="Hero Image">
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('heroes.edit', $hero) }}" class="btn btn-sm btn-info">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="{{ route('heroes.show', $hero) }}" class="btn btn-sm btn-success">
                                                    {{ __('Show') }}
                                                </a>
                                                <form action="{{ route('heroes.destroy', $hero) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
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
        new DataTable("#heroTable")
    </script>
@endpush
