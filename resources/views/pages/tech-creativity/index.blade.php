{{-- resources/views/pages/tech-creativity/index.blade.php --}}
@extends('layouts.app')

@section('content')
@include('users.partials.header', [
    'title' => __('Tech & Creativity Management'),
    'description' => __('Manage banners and categories with image directions'),
    'class' => 'col-lg-12',
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Overview') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('tech-creativity.create') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add New') }}
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
                        <table class="table align-items-center table-flush mt-3 w-100" id="tcTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">{{ __('Order') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Image Direction') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th width="120">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach ($items as $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td class="sortable-handle text-center" style="cursor: move;">
                                            <i class="fas fa-arrows-alt-v"></i>
                                        </td>
                                        <td>
                                            @if($item->cover_image)
                                            <img src="{{ asset($item->cover_image) }}" alt="{{ $item->title_en }}"
                                                 class="img-thumbnail" style="max-width: 100px;">
                                            @endif
                                        </td>
                                        <td><span class="badge badge-info text-uppercase">{{ $item->type }}</span></td>
                                        <td><span class="badge badge-secondary text-uppercase">{{ $item->image_direction }}</span></td>
                                        <td>{{ $item->title_en }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->description_en, 50) }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('tech-creativity.show', $item) }}"
                                                   class="btn btn-sm btn-info mr-2" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('tech-creativity.edit', $item) }}"
                                                   class="btn btn-sm btn-primary mr-2" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('tech-creativity.destroy', $item) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this item?');">
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

@push('css')
<style>
    .sortable-handle { cursor: move; cursor: -webkit-grabbing; }
    #sortable tr { cursor: move; }
    #sortable tr.sortable-selected { background-color: #f8f9fa; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
$(function(){
    const sortable = new Sortable(document.getElementById('sortable'), {
        handle: '.sortable-handle',
        animation: 150,
        onEnd: function() {
            const rows = $('#sortable tr');
            const order = [];
            rows.each(function(){ order.push($(this).data('id')); });

            $.ajax({
                url: "{{ route('tech-creativity.reorder') }}",
                type: 'POST',
                data: { items: order, _token: "{{ csrf_token() }}" },
                success: function(res){
                    if(res.success){
                        toastr && toastr.success('Order updated successfully');
                    }
                },
                error: function(){
                    toastr && toastr.error('Error updating order'); location.reload();
                }
            });
        }
    });

    new DataTable("#tcTable");
});
</script>
@endpush
