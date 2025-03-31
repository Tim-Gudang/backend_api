<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

    @stack('css')

    <!--   scan -->

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- Global stylesheets -->
    <link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->


    <!-- Core JS files -->
    <script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
    <script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!--menambahkan css -->
    <link href="{{ asset('template/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- /menambahkan css -->

    <!-- Theme JS files -->

    <link href="{{asset('template/assets/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('template/assets/icons/material/styles.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('template/assets/js/vendor/ui/fullcalendar/main.min.js')}}"></script>

    <link href="{{asset('template/assets/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
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
    <script src="{{ asset('template/assets/demo/pages/fullcalendar_styling.js')}}"></script>

    <!-- /theme JS files -->

</head>

<body>

<!-- Main navbar -->
   <div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
       <div class="container-fluid">
           <div class="d-flex d-lg-none me-2">
               <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                   <i class="ph-list"></i>
               </button>
           </div>

           <div class="navbar-brand flex-1 flex-lg-0">
               <a href="index.html" class="d-inline-flex align-items-center">
                   <img src="{{ asset('template/assets/images/logo_icon.svg') }}" alt="">
                   <img src="{{ asset('template/assets/images/logo_text_light.svg') }}"
                       class="d-none d-sm-inline-block h-16px ms-3" alt="">
               </a>
           </div>

           <ul class="nav flex-row">
               <li class="nav-item d-lg-none">
                   <a href="#navbar_search" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                       data-bs-toggle="collapse">
                       <i class="ph-magnifying-glass"></i>
                   </a>
               </li>
           </ul>
           <ul class="nav flex-row justify-content-end order-1 order-lg-2">
               <li class="nav-item ms-lg-2">
                   <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill"
                       data-bs-toggle="offcanvas" data-bs-target="#notifications">
                       <i class="ph-bell"></i>
                       <span
                           class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                   </a>
               </li>

               <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                   <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1"
                       data-bs-toggle="dropdown">
                       <div class="status-indicator-container">
                           <img src="{{ asset('template/assets/images/demo/users/face11.jpg') }}"
                               class="w-32px h-32px rounded-pill" alt="">
                           <span class="status-indicator bg-success"></span>
                       </div>
                       <span class="d-none d-lg-inline-block mx-lg-2">Victoria</span>
                   </a>

                   <div class="dropdown-menu dropdown-menu-end">
                       <a href="{{route('user_profile')}}" class="dropdown-item">
                           <i class="ph-user-circle me-2"></i>
                           My profile
                       </a>

                       <a href="{{route('login')}}" class="dropdown-item">
                           <i class="ph-sign-out me-2"></i>
                           Logout
                       </a>
                   </div>
               </li>
           </ul>
       </div>
   </div>
   <!-- /main navbar -->
