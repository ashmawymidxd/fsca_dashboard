@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Policy / Terms Management'),
        'description' => __('Here you can manage your policies and terms'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Policy / Terms Overview') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('policy-terms.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus"></i> {{ __('Add New') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush mt-3 w-100" id="policyTermsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50">{{ __('Order') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th width="120">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @foreach ($policyTerms as $policyTerm)
                                        <tr data-id="{{ $policyTerm->id }}">
                                            <td class="sortable-handle text-center" style="cursor: move;">
                                                <i class="fas fa-arrows-alt-v"></i>
                                            </td>
                                            <td>
                                                @if ($policyTerm->cover_image)
                                                    <img src="{{ asset($policyTerm->cover_image) }}"
                                                         alt="{{ $policyTerm->title_en }}"
                                                         class="img-thumbnail" style="max-width: 100px;">
                                                @endif
                                            </td>
                                            <td>{{ $policyTerm->title_en }}</td>
                                            <td><span class="badge badge-info">{{ ucfirst($policyTerm->type) }}</span></td>
                                            <td>{{ Str::limit($policyTerm->description_en, 50) }}</td>
                                            <td>{{ $policyTerm->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('policy-terms.show', $policyTerm) }}"
                                                       class="btn btn-sm btn-info mr-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('policy-terms.edit', $policyTerm) }}"
                                                       class="btn btn-sm btn-primary mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('policy-terms.destroy', $policyTerm) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
$(document).ready(function () {
    const sortable = new Sortable(document.getElementById('sortable'), {
        handle: '.sortable-handle',
        animation: 150,
        onEnd: function () {
            const order = [];
            $('#sortable tr').each(function () {
                order.push($(this).data('id'));
            });

            $.post("{{ route('policy-terms.reorder') }}", {
                policy_terms: order,
                _token: "{{ csrf_token() }}"
            }).done(() => toastr.success('Order updated successfully'))
              .fail(() => toastr.error('Error updating order'));
        }
    });
    new DataTable("#policyTermsTable");
});
</script>
@endpush
