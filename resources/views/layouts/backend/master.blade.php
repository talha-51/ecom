<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('back-end') }}/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('home.index') }}">
            {{-- @if (!$settings)
                <img src="{{ asset('images/logos/Image_not_available.png') }}" alt="logo"
                    style="width: 150px; height: 70px;">
            @else
                <img src="{{ asset($settings->logo) }}" alt="logo" style="width: 150px; height: 70px;">
            @endif --}}

            @if (!$settings)
                @else{{ $settings->company_name }}
            @endif
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading mt-3">Core</div>
                        <a class="nav-link" href="{{ route('admin.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Store</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#storeLayouts" aria-expanded="false" aria-controls="storeLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Home Page
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="storeLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('slider.index') }}">Hero Slider</a>
                            </nav>
                        </div>
                        <div class="collapse" id="storeLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('category.index') }}">Category</a>
                            </nav>
                        </div>
                        <div class="collapse" id="storeLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('sub-category.index') }}">Sub-Category</a>
                            </nav>
                        </div>
                        <div class="collapse" id="storeLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('product.index') }}">Product</a>
                            </nav>
                        </div>
                        <div class="collapse" id="storeLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('brand.index') }}">Brand</a>
                            </nav>
                        </div>


                        <div class="sb-sidenav-menu-heading">Orders</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#orderLayouts" aria-expanded="false" aria-controls="orderLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Order
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="orderLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('order.index') }}">Order List</a>
                            </nav>
                        </div>



                        <div class="sb-sidenav-menu-heading">Users</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#userLayouts" aria-expanded="false" aria-controls="userLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            User
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="userLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ route('admin.userList') }}">User List</a>
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">Settings</div>
                        <a class="nav-link" href="{{ route('settings.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Settings
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    {{ Auth::user()->name }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>

                {{-- alert --}}
                @if (session('success'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                        <div class="alert alert-success alert-dismissible fade show shadow" role="alert"
                            id="flashAlert">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                        <div class="alert alert-danger alert-dismissible fade show shadow" role="alert"
                            id="flashAlert">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            Copyright &copy; @if (!$settings)
                                @else{{ $settings->company_name }}
                            @endif {{ date('Y') }}
                        </div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('back-end') }}/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('back-end') }}/assets/demo/chart-area-demo.js"></script>
    <script src="{{ asset('back-end') }}/assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('back-end') }}/js/datatables-simple-demo.js"></script>

    {{-- Js for alert Start --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('flashAlert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    </script>
    {{-- Js for alert End --}}
</body>

</html>
