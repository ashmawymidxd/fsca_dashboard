@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Notifications'),
        'description' => __('Here you can view and manage all your notifications.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--6" data-aos="fade-up" data-aos-delay="200">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Notifications</h3>
                        <div class="float-right">
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Mark All as Read</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush w-100 mt-3" id="notificationsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $notification->data['message'] ?? 'Notification' }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($notification->read_at)
                                                <span class="badge badge-success">Read</span>
                                            @else
                                                <span class="badge badge-danger">Unread</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$notification->read_at)
                                                <a href="{{ route('notifications.read', $notification->id) }}"
                                                    class="btn btn-sm btn-info">Mark as Read</a>
                                            @endif
                                            <a href="{{ $notification->data['link'] ?? '#' }}"
                                                class="btn btn-sm btn-primary">View</a>
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
@endsection

@push('js')
    <script>
        new DataTable("#notificationsTable");
    </script>
@endpush
