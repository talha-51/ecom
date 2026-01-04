<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            /* Push footer to bottom */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
            background-color: black;
            border-radius: 50%;
            width: 45px;
            height: 45px;
        }



        /* ===== 5 CARDS PER ROW (LG UP) ===== */
        @media (min-width: 992px) {
            .col-lg-2-4 {
                width: 20%;
            }
        }

        /* ===== CARD ===== */
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* important */
        }

        /* IMAGE = 70% */
        .product-img {
            flex: 7;
            width: 100%;
            object-fit: contain;
            background: #f8f9fa;
            padding: 10px;
        }

        /* BODY = 30% */
        .product-body {
            flex: 3;
            display: flex;
            flex-direction: column;
        }


        /* FIXED TITLE HEIGHT */
        .title-fixed {
            min-height: 48px;
            line-height: 22px;
            font-size: 18px;
            font-weight: 600;
        }

        /* BIGGER PRICE */
        .price-fixed {
            min-height: 32px;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* BIGGER BUTTON AREA */
        .btn-area {
            min-height: 60px;
        }

        /* BIGGER BUTTONS */
        .btn-area .btn {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
        }

        html {
            scroll-behavior: smooth;
        }

        /* alert */
        #flashAlert {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <!-- Top Navbar Start -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                @if (!$settings)
                    <img src="{{ asset('images/logos/Image_not_available.png') }}" alt="logo"
                        style="width: 150px; height: 70px;">
                @else
                    <img src="{{ asset($settings->logo) }}" alt="logo" style="width: 150px; height: 70px;">
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fs-5">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page"
                                href="#{{ $category->name }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
                @auth
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('cart.index') }}" class="position-relative">
                            <button class="btn btn-success position-relative">
                                Cart
                                @if (isset($cartCount) && $cartCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </button>
                        </a>
                        <a href="{{ route('admin.index') }}">
                            <button class="btn btn-primary">Dashboard</button>
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}"><button class="btn btn-primary">Login</button></a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Top Navbar End -->

    <main>
        {{-- alert --}}
        @if (session('success'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                <div class="alert alert-success alert-dismissible fade show shadow" role="alert" id="flashAlert">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; margin-top: 70px;">
                <div class="alert alert-danger alert-dismissible fade show shadow" role="alert" id="flashAlert">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>


    <!-- Footer Start -->
    <footer class="bg-dark text-white pt-4 pb-2">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>About Us</h5>
                    <p>We provide high-quality computer components and accessories under the brand
                        @if (!$settings)
                            @else{{ $settings->company_name }}
                        @endif
                    </p>
                    <p>
                        Email:
                        @if (!$settings)
                            @else{{ $settings->email }}
                        @endif
                        <br>
                        <i class="bi bi-telephone">
                            @if (!$settings)
                                @else{{ $settings->contact_no }}
                            @endif
                        </i>
                    </p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Services</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Projects</a></li>
                        <li><a href="#" class="text-white text-decoration-none">About Us</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-3">
                    <h5>Follow Us</h5>
                    <a href="@if (!$settings) # @else{{ $settings->facebook }} @endif"
                        class="text-white fs-4 me-3" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="@if (!$settings) # @else{{ $settings->instagram }} @endif"
                        class="text-white fs-4 me-3" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="@if (!$settings) # @else{{ $settings->youtube }} @endif"
                        class="text-white fs-4" target="_blank"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <hr class="border-light">
            <p class="text-center mb-0">&copy; {{ date('Y') }}
                @if (!$settings)
                    @else{{ $settings->company_name }}
                @endif
            </p>
        </div>
    </footer>
    <!-- Footer End -->



    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        < script src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" >
    </script>

    </script>
</body>

</html>
