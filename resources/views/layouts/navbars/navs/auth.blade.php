<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand navbar-dark border-bottom border-info" id="navbar-main" style="background-color: rgba(2, 0, 92, 0.705)">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"
            href="{{ route('home') }}">{{ __('SFCL ADMIN FULL CONTROLE Dashboard') }}</a>

        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <!-- Notifications Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span
                            class="badge badge-secondary badge-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right dropdown-menu-notifications">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Notifications') }}</h6>
                        @if (auth()->user()->unreadNotifications->count() > 0)
                            <a href="{{ route('notifications.markAllAsRead') }}" class="text-sm text-muted">Mark all as
                                read</a>
                        @endif
                    </div>
                    <div style="max-height: 300px; overflow-y: scroll;">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ route('notifications.read', $notification->id) }}"
                                class="dropdown-item notification-item" data-notification-id="{{ $notification->id }}"
                                data-notification-link="{{ $notification->data['link'] ?? '#' }}">
                                <div class="media align-items-center">
                                    <div
                                        class="icon icon-shape icon-sm icon-{{ $notification->data['type'] ?? 'info' }} rounded-circle shadow mr-3">
                                        @if (isset($notification->data['type']) && $notification->data['type'] === 'contact')
                                            <i class="ni ni-email-83"></i>
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] === 'alert')
                                            <i class="ni ni-notification-70"></i>
                                        @else
                                            <i class="ni ni-bell-55"></i>
                                        @endif
                                    </div>
                                    <div class="media-body">
                                        <span
                                            class="text-sm">{{ $notification->data['message'] ?? 'New notification' }}</span>
                                        <p class="text-sm text-muted mb-0">
                                            <i class="ni ni-watch-time"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="dropdown-item">
                                <span class="text-sm text-muted px-6">{{ __('No new notifications yet ') }}</span>
                            </div>
                        @endforelse
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('notifications.index') }}"
                        class="dropdown-item text-center text-primary font-weight-bold">
                        {{ __('View all notifications') }}
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ni ni-ungroup"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
                    <div class="row shortcuts px-4">
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                                <i class="ni ni-calendar-grid-58"></i>
                            </span>
                            <small>Calendar</small>
                        </a>
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                                <i class="ni ni-email-83"></i>
                            </span>
                            <small>Email</small>
                        </a>
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                                <i class="ni ni-credit-card"></i>
                            </span>
                            <small>Payments</small>
                        </a>
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                                <i class="ni ni-books"></i>
                            </span>
                            <small>Reports</small>
                        </a>
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                                <i class="ni ni-pin-3"></i>
                            </span>
                            <small>Maps</small>
                        </a>
                        <a href="#!" class="col-4 shortcut-item">
                            <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                                <i class="ni ni-basket"></i>
                            </span>
                            <small>Shop</small>
                        </a>
                    </div>
                </div>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" style="object-fit:cover"
                                src="{{ asset('assets/profile_images/' . auth()->user()->profile_image) }}"
                                width="100%" height="100%">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">Hi 👋 {{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-circle-08"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-button-power"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle notification click
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    const notificationId = this.getAttribute('data-notification-id');
                    const link = this.getAttribute('data-notification-link');

                    // Mark as read via AJAX
                    fetch(`/notifications/${notificationId}/read`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then(response => {
                        if (response.ok) {
                            // Redirect to the notification link
                            window.location.href = link;
                        }
                    });
                });
            });
        });
    </script>
@endpush
