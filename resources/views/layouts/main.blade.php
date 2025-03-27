<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('template/assets/demo/pages/dashboard.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/streamgraph.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/sparklines.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/lines.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/areas.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/donuts.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/bars.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/progress.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/heatmaps.js') }}"></script>
    <script src="{{ asset('template/assets/demo/charts/pages/dashboard/pies.js') }}"></script>
    <script src="{{ asset('template/assets/demo/data/dashboard/bullets.json') }}"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    @include('layouts.navbar')

    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">

            <!-- Sidebar content -->
            @include('layouts.sidebar')

            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Page header -->
                <div class="page-header page-header-light shadow">
                    <div class="page-header-content d-lg-flex">
                        <div class="d-flex">
                            <h4 class="page-title mb-0">
                                Home - <span class="fw-normal">Dashboard</span>
                            </h4>

                            <a href="#page_header"
                                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                                data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>

                        <div class="collapse d-lg-block my-lg-auto ms-lg-auto" id="page_header">
                            <div class="d-sm-flex align-items-center mb-3 mb-lg-0 ms-lg-3">
                                <div class="dropdown w-100 w-sm-auto">
                                    <a href="#"
                                        class="d-flex align-items-center text-body lh-1 dropdown-toggle py-sm-2"
                                        data-bs-toggle="dropdown" data-bs-display="static">
                                        <img src="{{ asset('template/assets/images/brands/tesla.svg') }}"
                                            class="w-32px h-32px me-2" alt="">
                                        <div class="me-auto me-lg-1">
                                            <div class="fs-sm text-muted mb-1">Customer</div>
                                            <div class="fw-semibold">Tesla Motors Inc</div>
                                        </div>
                                    </a>

                                    <div
                                        class="dropdown-menu dropdown-menu-lg-end w-100 w-lg-auto wmin-300 wmin-sm-350 pt-0">
                                        <div class="d-flex align-items-center p-3">
                                            <h6 class="fw-semibold mb-0">Customers</h6>
                                            <a href="#" class="ms-auto">
                                                View all
                                                <i class="ph-arrow-circle-right ms-1"></i>
                                            </a>
                                        </div>
                                        <a href="#" class="dropdown-item active py-2">
                                            <img src="{{ asset('template/assets/images/brands/tesla.svg') }}"
                                                class="w-32px h-32px me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">Tesla Motors Inc</div>
                                                <div class="fs-sm text-muted">42 users</div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-2">
                                            <img src="{{ asset('template/assets/images/brands/debijenkorf.svg') }}"
                                                class="w-32px h-32px me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">De Bijenkorf</div>
                                                <div class="fs-sm text-muted">49 users</div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-2">
                                            <img src="{{ asset('template/assets/images/brands/klm.svg') }}"
                                                class="w-32px h-32px me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">Royal Dutch Airlines</div>
                                                <div class="fs-sm text-muted">18 users</div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-2">
                                            <img src="{{ asset('template/assets/images/brands/shell.svg') }}"
                                                class="w-32px h-32px me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">Royal Dutch Shell</div>
                                                <div class="fs-sm text-muted">54 users</div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item py-2">
                                            <img src="{{ asset('template/assets/images/brands/bp.svg') }}"
                                                class="w-32px h-32px me-2" alt="">
                                            <div>
                                                <div class="fw-semibold">BP plc</div>
                                                <div class="fs-sm text-muted">23 users</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="vr d-none d-sm-block flex-shrink-0 my-2 mx-3"></div>

                                <div class="d-inline-flex mt-3 mt-sm-0">
                                    <a href="#" class="status-indicator-container ms-1">
                                        <img src="{{ asset('template/assets/images/demo/users/face24.jpg') }}"
                                            class="w-32px h-32px rounded-pill" alt="">
                                        <span class="status-indicator bg-warning"></span>
                                    </a>
                                    <a href="#" class="status-indicator-container ms-1">
                                        <img src="{{ asset('template/assets/images/demo/users/face1.jpg') }}"
                                            class="w-32px h-32px rounded-pill" alt="">
                                        <span class="status-indicator bg-success"></span>
                                    </a>
                                    <a href="#" class="status-indicator-container ms-1">
                                        <img src="{{ asset('template/assets/images/demo/users/face3.jpg') }}"
                                            class="w-32px h-32px rounded-pill" alt="">
                                        <span class="status-indicator bg-danger"></span>
                                    </a>
                                    <a href="#"
                                        class="btn btn-outline-primary btn-icon w-32px h-32px rounded-pill ms-3">
                                        <i class="ph-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-header-content d-lg-flex border-top">
                        <div class="d-flex">
                            <div class="breadcrumb py-2">
                                <a href="index.html" class="breadcrumb-item"><i class="ph-house"></i></a>
                                <a href="#" class="breadcrumb-item">Home</a>
                                <span class="breadcrumb-item active">Dashboard</span>
                            </div>

                            <a href="#breadcrumb_elements"
                                class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                                data-bs-toggle="collapse">
                                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                            </a>
                        </div>

                        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
                            <div class="d-lg-flex mb-2 mb-lg-0">
                                <a href="#" class="d-flex align-items-center text-body py-2">
                                    <i class="ph-lifebuoy me-2"></i>
                                    Support
                                </a>

                                <div class="dropdown ms-lg-3">
                                    <a href="#" class="d-flex align-items-center text-body dropdown-toggle py-2"
                                        data-bs-toggle="dropdown">
                                        <i class="ph-gear me-2"></i>
                                        <span class="flex-1">Settings</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end w-100 w-lg-auto">
                                        <a href="#" class="dropdown-item">
                                            <i class="ph-shield-warning me-2"></i>
                                            Account security
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            <i class="ph-chart-bar me-2"></i>
                                            Analytics
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            <i class="ph-lock-key me-2"></i>
                                            Privacy
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">
                                            <i class="ph-gear me-2"></i>
                                            All settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Main charts -->
                    <div class="row">
                        <div class="col-xl-7">

                            <!-- Traffic sources -->
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="mb-0">Traffic sources</h5>
                                    <div class="ms-auto">
                                        <label class="form-check form-switch form-check-reverse">
                                            <input type="checkbox" class="form-check-input" checked>
                                            <span class="form-check-label">Live update</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <a href="#"
                                                    class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2 me-3">
                                                    <i class="ph-plus"></i>
                                                </a>
                                                <div>
                                                    <div class="fw-semibold">New visitors</div>
                                                    <span class="text-muted">2,349 avg</span>
                                                </div>
                                            </div>
                                            <div class="w-75 mx-auto mb-3" id="new-visitors"></div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <a href="#"
                                                    class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2 me-3">
                                                    <i class="ph-clock"></i>
                                                </a>
                                                <div>
                                                    <div class="fw-semibold">New sessions</div>
                                                    <span class="text-muted">08:20 avg</span>
                                                </div>
                                            </div>
                                            <div class="w-75 mx-auto mb-3" id="new-sessions"></div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <a href="#"
                                                    class="bg-indigo bg-opacity-10 text-indigo lh-1 rounded-pill p-2 me-3">
                                                    <i class="ph-users-three"></i>
                                                </a>
                                                <div>
                                                    <div class="fw-semibold">Total online</div>
                                                    <span class="text-muted">5,378 avg</span>
                                                </div>
                                            </div>
                                            <div class="w-75 mx-auto mb-3" id="total-online"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart position-relative" id="traffic-sources"></div>
                            </div>
                            <!-- /traffic sources -->

                        </div>

                        <div class="col-xl-5">

                            <!-- Sales stats -->
                            <div class="card">
                                <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                                    <h5 class="py-sm-2 my-sm-1">Sales statistics</h5>
                                    <div class="mt-2 mt-sm-0 ms-sm-auto">
                                        <select class="form-select" id="select_date">
                                            <option value="val1">June, 29 - July, 5</option>
                                            <option value="val2">June, 22 - June 28</option>
                                            <option value="val3" selected>June, 15 - June, 21</option>
                                            <option value="val4">June, 8 - June, 14</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-body pb-0">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <h5 class="mb-0">5,689</h5>
                                                <div class="text-muted fs-sm">new orders</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-3">
                                                <h5 class="mb-0">32,568</h5>
                                                <div class="text-muted fs-sm">this month</div>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="mb-3">
                                                <h5 class="mb-0">$23,464</h5>
                                                <div class="text-muted fs-sm">expected profit</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart mb-2" id="app_sales"></div>
                                <div class="chart" id="monthly-sales-stats"></div>
                            </div>
                            <!-- /sales stats -->

                        </div>
                    </div>
                    <!-- /main charts -->

                    <!-- Dashboard content -->
                    @include('layouts.dashboard_content')

                    <!-- /dashboard content -->

                </div>
                <!-- /content area -->

                <!-- Footer -->
                @include('layouts.footer')

                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->


    <!-- Notifications -->
    @include('layouts.components.notifications')

    <!-- /notifications -->


    <!-- Demo config -->
    @include('layouts.components.demo_config')

    <!-- /demo config -->

</body>

</html>
