@extends('layouts.app')
@push('css')
    <style>
        /* Custom CSS for enhanced dashboard */
        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            border-left: 4px solid;
        }

        .stat-card:nth-child(1) {
            border-left-color: #5e72e4;
        }

        .stat-card:nth-child(2) {
            border-left-color: #2dce89;
        }

        .stat-card:nth-child(3) {
            border-left-color: #11cdef;
        }

        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dot-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        #activityChart {
            height: 250px !important;
        }

        .welcome-card {
            border-left: 4px solid #5e72e4;
        }

        .wave-emoji {
            animation: wave 2s infinite;
            display: inline-block;
            transform-origin: 70% 70%;
        }

        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(-10deg);
            }

            20% {
                transform: rotate(12deg);
            }

            30% {
                transform: rotate(-10deg);
            }

            40% {
                transform: rotate(9deg);
            }

            50% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 600;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
        }
    </style>
@endpush
@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--6" data-aos="fade-out" data-aos-delay="200">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="bg-white rounded">
                    <div class="card-header bg-white border-0" data-aos="zoom-in" data-aos-delay="200">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0 text-primary">{{ __('Dashboard Overview') }}</h3>
                                <p class="text-muted mb-0">{{ __('Last updated: ') . now()->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-4 text-right">
                                <button class="btn btn-sm btn-neutral" id="refresh-dashboard">
                                    <i class="fas fa-sync-alt mr-2"></i>{{ __('Refresh') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary p-0 mt-2">
                        <!-- Welcome Section with User Focus -->
                        <div class="welcome-card mb-4 p-4 bg-white rounded-lg" data-aos="zoom-in" data-aos-delay="300">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h4 class="text-primary">{{ __('Welcome back, ') . auth()->user()->name }}! <span
                                            class="wave-emoji">👋</span></h4>
                                    <p class="text-muted">{{ __('Here\'s what\'s happening with your projects today.') }}
                                    </p>

                                </div>
                                <div class="col-lg-4 text-right d-none d-lg-block">
                                    <img src="{{ asset('argon') }}/img/brand/blue.png" alt="Dashboard Image"
                                        style="max-width: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Stats Cards with Hover Effects -->
                        <div class="row mb-4">
                            <!-- Projects Card -->
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="400">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">{{ __('Total Projects') }}</h6>
                                                <h2 class="mb-0 text-primary">{{ $projectsCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span class="badge badge-pill badge-soft-success">
                                                        <i class="fas fa-arrow-up mr-1"></i> {{ $projectsGrowth ?? 0 }}%
                                                        from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-primary-soft rounded-circle text-primary">
                                                <i class="fas fa-project-diagram"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary">
                                                {{ __('View Projects') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sustainabilities Card -->
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="500">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">
                                                    {{ __('Total Sustainabilities') }}</h6>
                                                <h2 class="mb-0 text-success">{{ $sustainabilitiesCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span class="badge badge-pill badge-soft-success">
                                                        <i class="fas fa-arrow-up mr-1"></i>
                                                        {{ $sustainabilitiesGrowth ?? 0 }}% from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-success-soft rounded-circle text-success">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('sustainabilities.index') }}"
                                                class="btn btn-sm btn-outline-success">
                                                {{ __('View Sustainabilities') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Support & Help Card -->
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="600">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">{{ __('Total Support & Help') }}
                                                </h6>
                                                <h2 class="mb-0 text-info">{{ $supportHelpsCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span class="badge badge-pill badge-soft-danger">
                                                        <i class="fas fa-arrow-down mr-1"></i>
                                                        {{ $supportHelpsGrowth ?? 0 }}% from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-info-soft rounded-circle text-info">
                                                <i class="fas fa-hands-helping"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('support-and-helps.index') }}"
                                                class="btn btn-sm btn-outline-info">
                                                {{ __('View Support') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="row mb-4">
                            <!-- Services Card -->
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="700">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">{{ __('Total Services') }}</h6>
                                                <h2 class="mb-0 text-warning">{{ $servicesCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ ($servicesGrowth ?? 0) >= 0 ? 'success' : 'danger' }}">
                                                        <i
                                                            class="fas fa-arrow-{{ ($servicesGrowth ?? 0) >= 0 ? 'up' : 'down' }} mr-1"></i>
                                                        {{ abs($servicesGrowth ?? 0) }}% from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-warning-soft rounded-circle text-warning">
                                                <i class="fas fa-concierge-bell"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('services.index') }}" class="btn btn-sm btn-outline-warning">
                                                {{ __('View Services') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Categories Card -->
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="800">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">{{ __('Service Categories') }}
                                                </h6>
                                                <h2 class="mb-0 text-purple">{{ $serviceCategoriesCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ ($serviceCategoriesGrowth ?? 0) >= 0 ? 'success' : 'danger' }}">
                                                        <i
                                                            class="fas fa-arrow-{{ ($serviceCategoriesGrowth ?? 0) >= 0 ? 'up' : 'down' }} mr-1"></i>
                                                        {{ abs($serviceCategoriesGrowth ?? 0) }}% from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-purple-soft rounded-circle text-purple">
                                                <i class="fas fa-tags"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="" class="btn btn-sm btn-outline-purple">
                                                {{ __('View Categories') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contacts Card -->
                            <div class="col-md-4" data-aos="fade-up" data-aos-delay="900">
                                <div class="card stat-card card-hover border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="text-uppercase text-muted mb-2">{{ __('Total Contacts') }}</h6>
                                                <h2 class="mb-0 text-danger">{{ $contactsCount ?? 0 }}</h2>
                                                <div class="mt-2">
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ ($contactsGrowth ?? 0) >= 0 ? 'success' : 'danger' }}">
                                                        <i
                                                            class="fas fa-arrow-{{ ($contactsGrowth ?? 0) >= 0 ? 'up' : 'down' }} mr-1"></i>
                                                        {{ abs($contactsGrowth ?? 0) }}% from last month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="icon-shape icon-lg bg-danger-soft rounded-circle text-danger">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('contacts.index') }}"
                                                class="btn btn-sm btn-outline-danger">
                                                {{ __('View Contacts') }} <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Chart with Date Range Selector -->
                        <div class="row" data-aos="fade-up" data-aos-delay="500">
                            <div class="col-lg-12">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h5 class="mb-0">{{ __('Monthly Activity') }}</h5>
                                            </div>
                                            <div class="col-auto">
                                                <select class="form-control form-control-sm" id="activityRange">
                                                    <option value="7">Last 7 days</option>
                                                    <option value="30" selected>Last 30 days</option>
                                                    <option value="90">Last 90 days</option>
                                                    <option value="365">Last year</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-container">
                                            <canvas id="activityChart" height="400"></canvas>
                                        </div>
                                        <div class="mt-3 d-flex flex-wrap justify-content-center">
                                            <div class="legend-item mr-4 mb-2">
                                                <span class="dot-indicator bg-primary"></span>
                                                <span class="text-muted ml-1">Projects</span>
                                            </div>
                                            <div class="legend-item mr-4 mb-2">
                                                <span class="dot-indicator bg-success"></span>
                                                <span class="text-muted ml-1">Sustainabilities</span>
                                            </div>
                                            <div class="legend-item mr-4 mb-2">
                                                <span class="dot-indicator bg-info"></span>
                                                <span class="text-muted ml-1">Support & Helps</span>
                                            </div>
                                            <div class="legend-item mr-4 mb-2">
                                                <span class="dot-indicator bg-warning"></span>
                                                <span class="text-muted ml-1">Services</span>
                                            </div>
                                            <div class="legend-item mr-4 mb-2">
                                                <span class="dot-indicator bg-purple"></span>
                                                <span class="text-muted ml-1">Service Categories</span>
                                            </div>
                                            <div class="legend-item mb-2">
                                                <span class="dot-indicator bg-danger"></span>
                                                <span class="text-muted ml-1">Contacts</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection



@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/moment/min/moment.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Activity Chart (Line with more options)
            var activityCtx = document.getElementById('activityChart').getContext('2d');
            var activityChart = new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($monthlyLabels) !!},
                    datasets: [{
                            label: 'Projects',
                            data: {!! json_encode($monthlyProjects) !!},
                            backgroundColor: 'rgba(94, 114, 228, 0.05)',
                            borderColor: 'rgba(94, 114, 228, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(94, 114, 228, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Sustainabilities',
                            data: {!! json_encode($monthlySustainabilities) !!},
                            backgroundColor: 'rgba(45, 206, 137, 0.05)',
                            borderColor: 'rgba(45, 206, 137, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(45, 206, 137, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Support & Helps',
                            data: {!! json_encode($monthlySupportHelps) !!},
                            backgroundColor: 'rgba(17, 205, 239, 0.05)',
                            borderColor: 'rgba(17, 205, 239, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(17, 205, 239, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Services',
                            data: {!! json_encode($monthlyServices) !!},
                            backgroundColor: 'rgba(255, 180, 0, 0.05)',
                            borderColor: 'rgba(255, 180, 0, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(255, 180, 0, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Service Categories',
                            data: {!! json_encode($monthlyServiceCategories) !!},
                            backgroundColor: 'rgba(123, 104, 238, 0.05)',
                            borderColor: 'rgba(123, 104, 238, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(123, 104, 238, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Contacts',
                            data: {!! json_encode($monthlyContacts) !!},
                            backgroundColor: 'rgba(250, 92, 124, 0.05)',
                            borderColor: 'rgba(250, 92, 124, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(250, 92, 124, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: '#fff',
                            titleColor: '#5e72e4',
                            bodyColor: '#8898aa',
                            borderColor: 'rgba(0, 0, 0, 0.05)',
                            borderWidth: 1,
                            padding: 15,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            });

            // Refresh button functionality
            document.getElementById('refresh-dashboard')?.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Refreshing...';
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            });

            // Date range selector for activity chart
            document.getElementById('activityRange').addEventListener('change', function() {
                // In a real app, you would fetch new data based on the selected range
                console.log('Date range changed to:', this.value + ' days');
                // For demo purposes, we'll just show a loading state
                const loadingIndicator = document.createElement('div');
                loadingIndicator.className = 'chart-loading text-center py-3';
                loadingIndicator.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading data...';
                document.querySelector('.chart-container').appendChild(loadingIndicator);

                setTimeout(() => {
                    document.querySelector('.chart-loading')?.remove();
                    // Here you would update the chart with new data
                    // Example: fetchNewChartData(this.value);
                }, 1500);
            });
        });
    </script>
@endpush
