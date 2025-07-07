<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>{{ $title ?? 'MyKAS' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Minimia: An advanced, fully responsive admin dashboard template packed with features to streamline your analytics and management needs." />
    <meta name="author" content="StackBros" />
    <meta name="keywords" content="Minimia, admin dashboard, responsive template, analytics, modern UI, management tools" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#ffffff">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Google Font Family link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Text:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>

<!-- START Wrapper -->
<div class="app-wrapper">

    <!-- Topbar Start -->
    <header class="app-topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="d-flex align-items-center gap-2">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                        <button type="button" class="button-toggle-menu topbar-button">
                            <iconify-icon icon="solar:hamburger-menu-broken"
                                          class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                        <button type="button" class="topbar-button" id="light-dark-mode">
                            <iconify-icon icon="solar:moon-broken"
                                          class="fs-22 align-middle light-mode"></iconify-icon>
                            <iconify-icon icon="solar:sun-2-broken"
                                          class="fs-22 align-middle dark-mode"></iconify-icon>
                        </button>
                    </div>

                    <!-- User -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                                      <span class="d-flex align-items-center">
                                           <img class="rounded" width="24" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="avatar-3">
                                      </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome!</h6>

                            <a class="dropdown-item" href="#">
                                <iconify-icon icon="solar:user-broken"
                                              class="align-middle me-2 fs-18"></iconify-icon><span class="align-middle">My
                                                Account</span>
                            </a>

                            <a class="dropdown-item" href="#">
                                <iconify-icon icon="solar:wallet-broken"
                                              class="align-middle me-2 fs-18"></iconify-icon><span
                                    class="align-middle">Pricing</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <iconify-icon icon="solar:help-broken"
                                              class="align-middle me-2 fs-18"></iconify-icon><span
                                    class="align-middle">Help</span>
                            </a>
                            <a class="dropdown-item" href="auth-lock-screen.html">
                                <iconify-icon icon="solar:lock-keyhole-broken"
                                              class="align-middle me-2 fs-18"></iconify-icon><span class="align-middle">Lock
                                                screen</span>
                            </a>

                            <div class="dropdown-divider my-1"></div>

                            <a class="dropdown-item text-danger" href="auth-signin.html">
                                <iconify-icon icon="solar:logout-3-broken"
                                              class="align-middle me-2 fs-18"></iconify-icon><span
                                    class="align-middle">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Topbar End -->

    <!-- App Menu Start -->
    <div class="app-sidebar">
        <!-- Sidebar Logo -->
        <div class="logo-box">
            <a href="index.html" class="logo-dark">
                <img src="assets/images/logo-sm.png" class="logo-sm" alt="logo sm">
                <img src="assets/images/logo-dark.png" class="logo-lg" alt="logo dark">
            </a>

            <a href="index.html" class="logo-light">
                <img src="assets/images/logo-sm.png" class="logo-sm" alt="logo sm">
                <img src="assets/images/logo-light.png" class="logo-lg" alt="logo light">
            </a>
        </div>

        <div class="scrollbar" data-simplebar>

            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title mt-2">Menu</li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:widget-5-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Dashboard </span>
                        <span class="badge bg-primary badge-pill text-end">New</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarAuthentication" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarAuthentication">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:user-circle-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Authentication </span>
                    </a>
                    <div class="collapse" id="sidebarAuthentication">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="auth-signin.html">Sign In</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="auth-signup.html">Sign Up</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="auth-password.html">Reset Password</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="auth-lock-screen.html">Lock Screen</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarError" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarError">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:danger-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Error Pages</span>
                    </a>
                    <div class="collapse" id="sidebarError">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="pages-404.html">Pages 404</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="pages-404-alt.html">Pages 404 Alt</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title">UI Kit</li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarBaseUI">
                        <span class="nav-icon"><iconify-icon icon="solar:leaf-broken"></iconify-icon></span>
                        <span class="nav-text"> Base UI </span>
                    </a>
                    <div class="collapse" id="sidebarBaseUI">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-accordion.html">Accordion</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-alerts.html">Alerts</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-avatar.html">Avatar</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-badge.html">Badge</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-breadcrumb.html">Breadcrumb</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-buttons.html">Buttons</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-card.html">Card</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-carousel.html">Carousel</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-collapse.html">Collapse</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-dropdown.html">Dropdown</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-list-group.html">List Group</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-modal.html">Modal</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-tabs.html">Tabs</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-offcanvas.html">Offcanvas</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-pagination.html">Pagination</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-placeholders.html">Placeholders</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-popovers.html">Popovers</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-progress.html">Progress</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-scrollspy.html">Scrollspy</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-spinners.html">Spinners</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-toasts.html">Toasts</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="ui-tooltips.html">Tooltips</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="charts.html">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:chart-square-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Apex Charts </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarForms">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:box-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Forms </span>
                    </a>
                    <div class="collapse" id="sidebarForms">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="forms-basic.html">Basic Elements</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="forms-flatpicker.html">Flatpicker</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="forms-validation.html">Validation</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="forms-fileuploads.html">File Upload</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="forms-editors.html">Editors</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarTables">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:checklist-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Tables </span>
                    </a>
                    <div class="collapse" id="sidebarTables">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="tables-basic.html">Basic Tables</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="tables-gridjs.html">Grid Js</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarIcons">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:crown-star-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Icons </span>
                    </a>
                    <div class="collapse" id="sidebarIcons">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="icons-boxicons.html">Boxicons</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="icons-solar.html">Solar Icons</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarMaps">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:map-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Maps </span>
                    </a>
                    <div class="collapse" id="sidebarMaps">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="maps-google.html">Google Maps</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="maps-vector.html">Vector Maps</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-title">Other</li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarLayouts" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarLayouts">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:window-frame-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Layouts </span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="layouts-dark-sidenav.html" target="_blank">Dark
                                    Sidenav</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="layouts-dark-topnav.html" target="_blank">Dark
                                    Topnav</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="layouts-small-sidenav.html" target="_blank">Small
                                    Sidenav</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="layouts-hidden-sidenav.html" target="_blank">Hidden
                                    Sidenav</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" target="_blank" href="layouts-dark.html">
                                    <span class="nav-text">Dark Mode</span>
                                    <span class="badge badge-soft-danger badge-pill text-end">Hot</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarMultiLevelDemo" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sidebarMultiLevelDemo">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:share-circle-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Menu Item </span>
                    </a>
                    <div class="collapse" id="sidebarMultiLevelDemo">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="javascript:void(0);">Menu Item 1</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link  menu-arrow" href="#sidebarItemDemoSubItem"
                                   data-bs-toggle="collapse" role="button" aria-expanded="false"
                                   aria-controls="sidebarItemDemoSubItem">
                                    <span> Menu Item 2 </span>
                                </a>
                                <div class="collapse" id="sidebarItemDemoSubItem">
                                    <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                            <a class="sub-nav-link" href="javascript:void(0);">Menu Sub item</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="javascript:void(0);">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:library-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text"> Disable Item </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- App Menu End -->

    <!-- ==================================================== -->
    <!-- Start right Content here -->
    <!-- ==================================================== -->
    <div class="page-content">

        <!-- Start Container Fluid -->
        <div class="container-fluid">

            <!-- ========== Page Title Start ========== -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h5 class="mb-0 text-uppercase fw-bold">Dashboard</h5>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minimia</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- ========== Page Title End ========== -->

            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md text-bg-secondary rounded-circle">
                                        <iconify-icon icon="solar:globus-broken"
                                                      class="fs-32 avatar-title"></iconify-icon>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Clicks</p>
                                    <h3 class="text-dark mt-2 mb-0">15,352</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-success"> <i class="bx bxs-up-arrow fs-12"></i> 3.02%</span>
                                    <span class="text-muted ms-1 fs-12">From last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md text-bg-primary rounded-circle">
                                        <iconify-icon icon="solar:bag-check-broken"
                                                      class="fs-32 avatar-title"></iconify-icon>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Sales</p>
                                    <h3 class="text-dark mt-2 mb-0">8,764</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-danger"> <i class="bx bxs-down-arrow fs-12"></i> 1.15%</span>
                                    <span class="text-muted ms-1 fs-12">From last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md text-bg-secondary rounded-circle">
                                        <iconify-icon icon="solar:calendar-date-broken"
                                                      class="fs-32 avatar-title"></iconify-icon>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Events</p>
                                    <h3 class="text-dark mt-2 mb-0">5,123</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-success"> <i class="bx bxs-up-arrow fs-12"></i> 4.78%</span>
                                    <span class="text-muted ms-1 fs-12">From last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md text-bg-primary rounded-circle">
                                        <iconify-icon icon="solar:users-group-two-rounded-broken"
                                                      class="fs-32 avatar-title"></iconify-icon>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Users</p>
                                    <h3 class="text-dark mt-2 mb-0">12,945</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-2 bg-light bg-opacity-50 mx-2 mb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-success"> <i class="bx bxs-up-arrow fs-12"></i> 2.35%</span>
                                    <span class="text-muted ms-1 fs-12">From last month</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-4">
                    <div class="card ">
                        <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="card-title mb-0">Top Pages</h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-soft-primary">ALL</button>
                                <button type="button" class="btn btn-sm btn-soft-primary">1M</button>
                                <button type="button" class="btn btn-sm btn-soft-primary">6M</button>
                                <button type="button" class="btn btn-sm btn-soft-primary active">1Y</button>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div dir="ltr">
                                <div id="dash-performance-chart" class="apex-charts"></div>
                            </div>
                        </div>

                    </div> <!-- end card-->
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card ">
                        <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="card-title mb-0">Sessions by Country</h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-soft-primary">ALL</button>
                                <button type="button" class="btn btn-sm btn-soft-primary active">1M</button>
                                <button type="button" class="btn btn-sm btn-soft-primary">6M</button>
                                <button type="button" class="btn btn-sm btn-soft-primary">1Y</button>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div id="world-map-markers" class="mt-1" style="height: 283px">
                            </div>

                            <div class="mt-2">
                                <div class="text-center d-flex gap-3 justify-content-center align-items-center">
                                    <span><i class="bx bx-circle text-muted"></i> USA - <span class="fw-semibold">289</span> </span>
                                    <span><i class="bx bx-circle text-muted"></i> Canada - <span class="fw-semibold">105</span> </span>
                                    <span><i class="bx bx-circle text-muted"></i> Brazil - <span class="fw-semibold">63</span> </span>
                                    <span><i class="bx bx-circle text-muted"></i> Russia - <span class="fw-semibold">218</span> </span>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-->
                </div> <!-- end col -->

                <div class="col-lg-4">
                    <div class="card ">
                        <div class="d-flex card-header justify-content-between align-items-center border-bottom border-dashed">
                            <h4 class="card-title mb-0">Customer Reviews</h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary">View All</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="flex-1">
                                    <div class="d-flex align-items-baseline mb-1">
                                        <h4 class="mb-0 text-muted">4.95</h4>
                                        <span class="ms-2 fs-16">
                                                <i class="bx bxs-star text-warning"></i>
                                                <i class="bx bxs-star text-warning"></i>
                                                <i class="bx bxs-star text-warning"></i>
                                                <i class="bx bxs-star text-warning"></i>
                                                <i class="bx bxs-star-half text-warning"></i>
                                            </span>
                                    </div>
                                </div>
                                <div>
                                    <span class="fs-14">(18,521 Reviews)</span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="d-block fw-medium">5 Stars</span>
                                            <span class="d-block ">73.9%</span>
                                        </div>
                                        <div class="progress progress-md mt-1" role="progressbar" aria-valuenow="73.9" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 73.9%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="d-block fw-medium">4 Stars</span>
                                            <span class="d-block ">52.8%</span>
                                        </div>
                                        <div class="progress progress-md mt-1" role="progressbar" aria-valuenow="52.8" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 52.8%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="d-block fw-medium">3 Stars</span>
                                            <span class="d-block ">22.5%</span>
                                        </div>
                                        <div class="progress progress-md mt-1" role="progressbar" aria-valuenow="22.5" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 22.5%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="d-block fw-medium">2 Stars</span>
                                            <span class="d-block ">21.4%</span>
                                        </div>
                                        <div class="progress progress-md mt-1" role="progressbar" aria-valuenow="21.4" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 21.4%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-fill">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="d-block fw-medium">1 Star</span>
                                            <span class="d-block ">5.5%</span>
                                        </div>
                                        <div class="progress progress-md mt-1" role="progressbar" aria-valuenow="5.5" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar bg-primary" style="width: 5.5%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div> <!-- End row -->

            <div class="row">
                <!-- Start Recent Order -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0">Recent Orders</h5>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">

                                    <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Created</th>
                                        <th>Modified</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">#8721</a>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <img src="assets/images/users/avatar-1.jpg" class="avatar-sm rounded-circle me-2" />
                                            <div>
                                                <p class="mb-0 fw-medium fs-14">Alice Brown</p>
                                                <p class="text-muted fs-13 mb-0">alice@domain.com</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">50</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">$725.00</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">October 15, 2023</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">November 10, 2023</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success fw-semibold">Completed</span>
                                        </td>
                                        <td>
                                            <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <i class="bx bx-edit fs-14 text-primary"></i>
                                            </a>
                                            <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <i class="bx bx-x fs-14 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">#6543</a>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <img src="assets/images/users/avatar-2.jpg" class="avatar-sm rounded-circle me-2" />
                                            <div>
                                                <p class="mb-0 fw-medium fs-14">John Smith</p>
                                                <p class="text-muted fs-13 mb-0">johnsmith@domain.com</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">74</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">$620.00</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">July 22, 2023</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">August 05, 2023</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger fw-semibold">Cancelled</span>
                                        </td>
                                        <td>
                                            <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <i class="bx bx-edit fs-14 text-primary"></i>
                                            </a>
                                            <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <i class="bx bx-x fs-14 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">#9804</a>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <img src="assets/images/users/avatar-3.jpg" class="avatar-sm rounded-circle me-2" />
                                            <div>
                                                <p class="mb-0 fw-medium fs-14">Samantha Davis</p>
                                                <p class="text-muted fs-13 mb-0">samantha@domain.com</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">63</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">$450.00</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">May 18, 2023</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">May 30, 2023</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info fw-semibold">Pending</span>
                                        </td>
                                        <td>
                                            <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <i class="bx bx-edit fs-14 text-primary"></i>
                                            </a>
                                            <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <i class="bx bx-x fs-14 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">#7832</a>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <img src="assets/images/users/avatar-4.jpg" class="avatar-sm rounded-circle me-2" />
                                            <div>
                                                <p class="mb-0 fw-medium fs-14">Michael Scott</p>
                                                <p class="text-muted fs-13 mb-0">michael.scott@domain.com</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">65</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">$980.00</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">August 10, 2023</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">August 20, 2023</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning fw-semibold">Shipped</span>
                                        </td>
                                        <td>
                                            <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <i class="bx bx-edit fs-14 text-primary"></i>
                                            </a>
                                            <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <i class="bx bx-x fs-14 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href="javascript:void(0);" class="text-muted">#4589</a>
                                        </td>
                                        <td class="d-flex align-items-center">
                                            <img src="assets/images/users/avatar-5.jpg" class="avatar-sm rounded-circle me-2" />
                                            <div>
                                                <p class="mb-0 fw-medium fs-14">Jessica Miller</p>
                                                <p class="text-muted fs-13 mb-0">jessica.miller@domain.com</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0">82</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">$1,250.00</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">September 05, 2023</p>
                                        </td>
                                        <td>
                                            <p class="mb-0">September 15, 2023</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary fw-semibold">Delivered</span>
                                        </td>
                                        <td>
                                            <a aria-label="anchor" class="btn btn-sm bg-primary-subtle me-1" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                <i class="bx bx-edit fs-14 text-primary"></i>
                                            </a>
                                            <a aria-label="anchor" class="btn btn-sm bg-danger-subtle" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                <i class="bx bx-x fs-14 text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <div class="align-items-center justify-content-between row g-0 text-center text-sm-start p-3 border-top">
                                <div class="col-sm">
                                    <div class="text-muted">
                                        Showing <span class="fw-semibold">5</span> of <span
                                            class="fw-semibold">7,021</span> orders
                                    </div>
                                </div>
                                <div class="col-sm-auto mt-3 mt-sm-0">
                                    <ul class="pagination pagination-rounded m-0">
                                        <li class="page-item">
                                            <a href="#" class="page-link"><i class='bx bx-left-arrow-alt'></i></a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link"><i class='bx bx-right-arrow-alt'></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Recent Order -->
            </div>

        </div>
        <!-- End Container Fluid -->

        <!-- Footer Start -->
        <footer class="footer card mb-0 rounded-0 justify-content-center align-items-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">
                            <script>document.write(new Date().getFullYear())</script> &copy; Minimia.</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

    </div>
    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->

</div>
<!-- END Wrapper -->

<!-- Vendor Javascript -->
<script src="assets/js/vendor.min.js"></script>

<!-- App Javascript -->
<script src="assets/js/app.js"></script>

<!-- Vector Map Js -->
<script src="assets/vendor/jsvectormap/js/jsvectormap.min.js"></script>
<script src="assets/vendor/jsvectormap/maps/world-merc.js"></script>
<script src="assets/vendor/jsvectormap/maps/world.js"></script>

<!-- Dashboard Js -->
<script src="assets/js/pages/dashboard.js"></script>

</body>

</html>
