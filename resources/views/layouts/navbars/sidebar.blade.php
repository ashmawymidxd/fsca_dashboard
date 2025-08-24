<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="Xamble Logo">
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
                            <img src="{{ asset('argon') }}/img/brand/blue.png" alt="Xamble Logo">
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
                <li class="nav-item">
                    <a class="nav-link text-left pl-4 {{ Request::is('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        <i class="ni ni-chart-bar-32 text-primary"></i>
                        <span class="nav-link-text">Overview</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('services*') ? 'active' : '' }}"
                        href="{{ route('services.index') }}">
                        <i class="ni ni-single-copy-04 text-primary"></i>
                        <span class="nav-link-text">Services Pages</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('common-units*') ? 'active' : '' }}"
                        href="{{ route('common-units.index') }}">
                        <i class="ni ni-ui-04 text-primary"></i>
                        <span class="nav-link-text">Common Units</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('settings*') ? 'active' : '' }}"
                        href="{{ route('settings.index') }}">
                        <i class="ni ni-settings text-primary"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                </li>

                <!-- Section Header -->
                <li class="nav-item mt-3 mb-1">
                    <span class="nav-link text-uppercase text-xs font-weight-bold">Categories</span>
                </li>

                <!-- Collapsible Menu Item with auto-open based on active child -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('complete_services*') || Request::is('sectors*') ? 'active' : '' }}"
                        href="#navbar-examples" data-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('complete_services*') || Request::is('sectors*') ? 'true' : 'false' }}"
                        aria-controls="navbar-examples">
                        <i class="ni ni-compass-04 text-primary"></i>
                        <span class="nav-link-text">{{ __('Landing Page') }}</span>

                    </a>

                    <div class="collapse {{ Request::is('complete_services*') || Request::is('our-supports*') || Request::is('certificates*') || Request::is('about-us*') || Request::is('banners*') || Request::is('blogs*') || Request::is('customers*') || Request::is('videos*') || Request::is('who_we_are*') || Request::is('heroes*') || Request::is('sectors*') ? 'show' : '' }}"
                        id="navbar-examples">
                        <ul class="nav nav-sm flex-column ps-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('heroes*') ? 'active' : '' }}"
                                    href="{{ route('heroes.index') }}">
                                    <i class="ni ni-tv-2 text-primary"></i>
                                    <span class="nav-link-text">{{ __('Hero') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('about-us*') ? 'active' : '' }}"
                                    href="{{ route('about-us.index') }}">
                                    <i class="ni ni-diamond text-primary"></i>
                                    <span class="nav-link-text">About Us</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('who_we_are*') ? 'active' : '' }}"
                                    href="{{ route('who_we_are.index') }}">
                                    <i class="ni ni-paper-diploma text-primary"></i>
                                    <span class="nav-link-text">{{ __('Who we are') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('complete_services*') ? 'active' : '' }}"
                                    href="{{ route('complete_services.index') }}">
                                    <i class="ni ni-briefcase-24 text-primary"></i>
                                    <span class="nav-link-text">{{ __('Services') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('videos*') ? 'active' : '' }}"
                                    href="{{ route('videos.index') }}">
                                    <i class="ni ni-button-play text-primary"></i>
                                    <span class="nav-link-text">{{ __('Videos') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('sectors*') ? 'active' : '' }}"
                                    href="{{ route('sectors.index') }}">
                                    <i class="ni ni-books text-primary"></i>
                                    <span class="nav-link-text">{{ __('Sectors') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('customers*') ? 'active' : '' }}"
                                    href="{{ route('customers.index') }}">
                                    <i class="ni ni-single-02 text-primary"></i>
                                    <span class="nav-link-text">{{ __('Customers') }}</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('blogs*') ? 'active' : '' }}"
                                    href="{{ route('blogs.index') }}">
                                    <i class="ni ni-bullet-list-67 text-primary"></i>
                                    <span class="nav-link-text">Blogs</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('banners*') ? 'active' : '' }}"
                                    href="{{ route('banners.index') }}">
                                    <i class="ni ni-image text-primary"></i>
                                    <span class="nav-link-text">Banners</span>
                                </a>
                            </li>

                            {{-- certificates --}}
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('certificates*') ? 'active' : '' }}"
                                    href="{{ route('certificates.index') }}">
                                    <i class="ni ni-paper-diploma text-primary"></i>
                                    <span class="nav-link-text">Certificates</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('our-supports*') ? 'active' : '' }}"
                                    href="{{ route('our-supports.index') }}">
                                    <i class="ni ni-support-16 text-primary"></i>
                                    <span class="nav-link-text">Our Supports</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <!-- Collapsible Menu Item with auto-open based on active child -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('projects*') || Request::is('support-and-helps*') || Request::is('sustainabilities*') || Request::is('fleets*') || Request::is('trains*') ? 'active' : '' }}"
                        href="#navbar-examples2" data-toggle="collapse" role="button"
                        aria-expanded="{{ Request::is('projects*') || Request::is('support-and-helps*') || Request::is('sustainabilities*') || Request::is('fleets*') || Request::is('trains*') ? 'true' : 'false' }}"
                        aria-controls="navbar-examples2">
                        <i class="ni ni-collection text-primary"></i>
                        <span class="nav-link-text">{{ __('Pages Content') }}</span>

                    </a>

                    <div class="collapse {{ Request::is('projects*') || Request::is('policy-terms*') || Request::is('tech-creativity*') || Request::is('support-and-helps*') || Request::is('sustainabilities*') || Request::is('fleets*') || Request::is('trains*') ? 'show' : '' }}"
                        id="navbar-examples2">
                        <ul class="nav nav-sm flex-column ps-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('projects*') ? 'active' : '' }}"
                                    href="{{ route('projects.index') }}">
                                    <i class="ni ni-bulb-61 text-primary"></i>
                                    <span class="nav-link-text">Projects</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('support-and-helps*') ? 'active' : '' }}"
                                    href="{{ route('support-and-helps.index') }}">
                                    <i class="ni ni-shop text-primary"></i>
                                    <span class="nav-link-text">Support & Help</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('sustainabilities*') ? 'active' : '' }}"
                                    href="{{ route('sustainabilities.index') }}">
                                    <i class="ni ni-planet text-primary"></i>
                                    <span class="nav-link-text">Sustainabilities</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('fleets*') ? 'active' : '' }}"
                                    href="{{ route('fleets.index') }}">
                                    <i class="ni ni-ambulance text-primary"></i>
                                    <span class="nav-link-text">Fleet Manage</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('trains*') ? 'active' : '' }}"
                                    href="{{ route('trains.index') }}">
                                    <i class="ni ni-user-run text-primary"></i>
                                    <span class="nav-link-text">Trains Centers</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('tech-creativity*') ? 'active' : '' }}"
                                    href="{{ route('tech-creativity.index') }}">
                                    <i class="ni ni-compass-04 text-primary"></i>
                                    <span class="nav-link-text">Tech Creativity</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('policy-terms*') ? 'active' : '' }}"
                                    href="{{ route('policy-terms.index') }}">
                                    <i class="ni ni-caps-small text-primary"></i>
                                    <span class="nav-link-text">Policy Terms</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Section Header -->
                <li class="nav-item mt-3 mb-1">
                    <span class="nav-link text-uppercase text-xs font-weight-bold">Clients & Staff</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admins*') ? 'active' : '' }}"
                        href="{{ route('admins.index') }}">
                        <i class="ni ni-bullet-list-67 text-primary"></i>
                        <span class="nav-link-text">Admins</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contacts*') ? 'active' : '' }}"
                        href="{{ route('contacts.index') }}">
                        <i class="ni ni-email-83 text-primary"></i>
                        <span class="nav-link-text">Clients Contacts</span>
                    </a>
                </li>
            </ul>

            <!-- User Profile (Desktop) -->
            <div class="mt-auto d-none d-md-block border bg-secondary rounded p-3">
                <a href="{{ route('profile.edit') }}" class="nav-link p-0" role="button">
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
            </div>
        </div>
    </div>
</nav>
