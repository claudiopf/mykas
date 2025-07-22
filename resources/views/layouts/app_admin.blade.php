<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>{{ $title ?? 'MyKAS' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="StackBros" />
    <meta name="keywords" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Google Font Family link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Text:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">

    <!-- Vendor css -->
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables css -->
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- Theme Config js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Dashboard js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                            <iconify-icon icon="solar:moon-broken" class="fs-22 align-middle light-mode"></iconify-icon>
                            <iconify-icon icon="solar:sun-2-broken" class="fs-22 align-middle dark-mode"></iconify-icon>
                        </button>
                    </div>
                    <!-- User -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded" width="24" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="avatar-3">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}</h6>
                            <a class="dropdown-item" href="#">
                                <iconify-icon icon="solar:user-broken" class="align-middle me-2 fs-18"></iconify-icon>
                                <span class="align-middle">MyAccount</span>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                    <iconify-icon icon="solar:logout-3-broken" class="fs-18"></iconify-icon>
                                    <span>Logout</span>
                                </button>
                            </form>
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
        <div class="logo-box d-flex align-items-center justify-content-center">
            <a href="{{ route('home') }}" class="text-center text-white">
                KAS
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
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#masterdata" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="masterdata">
                                 <span class="nav-icon">
                                      <iconify-icon icon="solar:folder-with-files-broken"></iconify-icon>
                                 </span>
                        <span class="nav-text">Master Data</span>
                    </a>
                    <div class="collapse" id="masterdata">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{ route('area.index') }}">Area</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{ route('brand.index') }}">Brand</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{ route('product.index') }}">Produk</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{ route('retail.index') }}">Toko</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sales" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="sales">
                                 <span class="nav-icon">
                                      <iconify-icon icon="carbon:sales-ops"></iconify-icon>
                                 </span>
                        <span class="nav-text">Sales</span>
                    </a>
                    <div class="collapse" id="sales">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Sales Order</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Transaksi</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Track Sales</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Pencapaian Sales</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Pencapaian Toko</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#userManagement" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="userManagement">
                                 <span class="nav-icon">
                                      <iconify-icon icon="icon-park:user"></iconify-icon>
                                 </span>
                        <span class="nav-text">User Management</span>
                    </a>
                    <div class="collapse" id="userManagement">
                        <ul class="nav sub-navbar-nav">
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="{{ route('user_management.index') }}">Tambah/Ubah</a>
                            </li>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="#">Hak Akses</a>
                            </li>
                        </ul>
                    </div>
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
            @yield('content')
        </div>
        <!-- End Container Fluid -->

        <!-- Footer Start -->
        <footer class="footer card mb-0 rounded-0 justify-content-center align-items-center">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">
                            <script>document.write(new Date().getFullYear())</script> &copy; KAS.</a>
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
@stack('scripts')
<!-- Vendor Javascript -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

<!-- App Javascript -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Dashboard Js -->
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

</body>

</html>
