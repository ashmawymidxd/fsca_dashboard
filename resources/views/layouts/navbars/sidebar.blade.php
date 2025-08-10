<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>

        <!-- User (Mobile View) -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle mr-3">
                            <img alt="Profile Image" style="object-fit:cover"
                                src="{{ asset('assets/profile_images/' . auth()->user()->profile_image) }}"
                                width="100%" height="100%">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02 text-primary"></i> {{ __('My profile') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run text-danger"></i> {{ __('Logout') }}
                    </a>
                </div>
            </li>
        </ul>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">

            <!-- Collapse header (Mobile) -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <!-- Dashboard with dropdown -->
                <li class="nav-item">
                    <div class="nav-link d-flex justify-content-between align-items-center" data-toggle="collapse"
                        href="#dashboardCollapse" role="button" aria-expanded="false"
                        aria-controls="dashboardCollapse">
                        <div>
                            <i class="ni ni-collection text-primary mr-4"></i>Home
                        </div>
                    </div>
                    <div class="collapse pl-4" id="dashboardCollapse">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-left pl-4 {{ Request::is('complete_services*') ? 'active' : '' }}"
                                    href="{{ route('complete_services.index') }}">
                                    <i class="ni ni-briefcase-24 text-primary "></i> Services
                                </a>
                            </li>
                            {{-- sectors --}}
                            <li class="nav-item">
                                <a class="nav-link text-left pl-4 {{ Request::is('sectors*') ? 'active' : '' }}"
                                    href="{{ route('sectors.index') }}">
                                    <i class="ni ni-bullet-list-67 text-primary"></i> Sectors
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-left pl-4 {{ Request::is('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        <i class="ni ni-chart-bar-32 text-primary"></i> Overview
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('services*') ? 'active' : '' }}"
                        href="{{ route('services.index') }}">
                        <i class="ni ni-settings text-primary"></i> Services Pages
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('common-units*') ? 'active' : '' }}"
                        href="{{ route('common-units.index') }}">
                        <i class="ni ni-ui-04 text-primary"></i> Common Units
                    </a>
                </li>

                <li class="nav-item">
                    <span class="nav-link">Pages Content</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('projects*') ? 'active' : '' }}"
                        href="{{ route('projects.index') }}">
                        <i class="ni ni-collection text-primary"></i> Projects
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('support-and-helps*') ? 'active' : '' }}"
                        href="{{ route('support-and-helps.index') }}">
                        <i class="ni ni-shop text-primary"></i> Support & Help
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sustainabilities*') ? 'active' : '' }}"
                        href="{{ route('sustainabilities.index') }}">
                        <i class="ni ni-planet text-primary"></i> Sustainabilities
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('fleets*') ? 'active' : '' }}"
                        href="{{ route('fleets.index') }}">
                        <i class="ni ni-ambulance text-primary"></i> Fleet Management
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('trains*') ? 'active' : '' }}"
                        href="{{ route('trains.index') }}">
                        <i class="ni ni-user-run text-primary"></i> Trains Centers
                    </a>
                </li>

                <li class="nav-item">
                    <span class="nav-link">Clients & Staff</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admins*') ? 'active' : '' }}"
                        href="{{ route('admins.index') }}">
                        <i class="ni ni-bullet-list-67 text-primary"></i> Admins
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contacts*') ? 'active' : '' }}"
                        href="{{ route('contacts.index') }}">
                        <i class="ni ni-email-83 text-primary"></i> Clients Contacts
                    </a>
                </li>
            </ul>


            {{-- <div class="mt-auto d-none d-md-block border bg-secondary rounded">
                <a href="{{ route('profile.edit') }}" class="nav-link py-1" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle mr-3">
                            <img alt="Profile Image" style="object-fit:cover"
                                src="{{ asset('assets/profile_images/' . auth()->user()->profile_image) }}"
                                width="100%" height="100%">
                        </span>
                        <div class="media-body">
                            <h6 class="text-sm font-weight-600 mb-0">{{ auth()->user()->name }}</h6>
                            <p class="text-xs text-muted mb-0">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
    </div>
</nav>
