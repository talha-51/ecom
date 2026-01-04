@extends('layouts.frontend.master')

@section('title')
    @if (!$settings)
    @else
        {{ $settings->company_name }}
    @endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Hero Carousel Start -->
            <div class="col-12">
                {{-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    @if ($sliders->isEmpty())
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/sliders/Image_not_available.png') }}"
                                    class="d-block w-100 img-fluid object-fit-contain" style="max-height: 80vh;" />
                            </div>
                        </div>
                    @else
                        <!-- Dynamic slides -->
                        <div class="carousel-inner">
                            @foreach ($sliders as $key => $slider)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" data-bs-interval="3000">
                                    <img src="{{ asset($slider->image) }}" class="d-block w-100"
                                        style="height: 80vh; object-fit: cover;" alt="Slider image">
                                </div>
                            @endforeach
                        </div>

                        <!-- Previous -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark bg-opacity-75 p-3 rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>

                        <!-- Next -->
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark bg-opacity-75 p-3 rounded-circle"
                                aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div> --}}

                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($sliders as $slider)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset($slider->image) }}" class="d-block w-100"
                                    style="height: 80vh; object-fit: contain;" alt="Slider image">
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

            </div>
            <!-- Hero Carousel End -->
        </div>
    </div>

    <!-- Catagories marquee Start -->
    <div class="container-fluid mt-5">
        <div class="container-fluid text-center">
            <h1>Categories</h1>
        </div>
        <marquee class="mt-2" scrollamount="10" width="100%" direction="left" height="220px">
            <div class="d-flex">
                @foreach ($categories as $category)
                    {{-- for single dynamic page --}}

                    <a href="{{ route('home.filteredProducts', ['type' => 'category', 'name' => str_replace(' ', '-', $category->name)]) }}"
                        class="text-decoration-none">
                        <div class="text-center mx-4">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                class="img-thumbnail rounded-circle object-fit-cover mb-2"
                                style="width: 150px; height: 150px;">
                            <div class="fw-bold fs-5 text-dark">{{ $category->name }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </marquee>
    </div>
    <!-- Categories marquee End -->

    <!-- Products Card carousel grouped by category Start -->
    @foreach ($categories as $category)
        <div class="container-fluid text-center mb-5">
            <section id="{{ $category->name }}">
                <h1 class="mb-4">{{ $category->name }}</h1>

                <div class="row g-3">
                    @foreach ($products->where('cat_id', $category->id) as $product)
                        <div class="col-6 col-md-4 col-lg-2-4">
                            <div class="product-card">
                                <img src="{{ asset($product->image) }}" class="product-img" alt="{{ $product->name }}">

                                <div class="product-body bg-primary-subtle text-primary-emphasis">

                                    <!-- FIXED TITLE -->
                                    <h5 class="card-title title-fixed text-center mt-3">
                                        {{ $product->name }}
                                    </h5>

                                    <!-- PRICE -->
                                    <p class="card-text price-fixed text-center">
                                        Price: <b>{{ $product->price }}</b> BDT
                                    </p>

                                    <!-- BUTTONS STICK TO BOTTOM -->
                                    <div class="btn-area mt-auto text-center">
                                        <form action="{{ route('cart.addToCart', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm">Add to
                                                Cart</button>
                                        </form>

                                        <form action="{{ route('cart.onepagecheckout', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Buy Now</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    @endforeach
    <!-- Products Card carousel grouped by category End -->


    <!-- Brand Section Start -->
    <div class="container-fluid mt-5">
        <div class="container-fluid text-center">
            <h1 class="mb-4">Brands</h1>
        </div>
        <marquee class="mt-2" scrollamount="10" width="100%" direction="left" height="220px">
            <div class="d-flex">
                @foreach ($brands as $brand)
                    {{-- for single dynamic page --}}

                    <a href="{{ route('home.filteredProducts', ['type' => 'brand', 'name' => str_replace(' ', '-', $brand->name)]) }}"
                        class="text-decoration-none">
                        <div class="text-center mx-4">
                            <img src="{{ $brand->image }}" class="img-thumbnail rounded-circle object-fit-cover mb-2"
                                style="width: 150px; height: 150px;">
                            <div class="fw-bold fs-5 text-dark">{{ $brand->name }}</div>
                        </div>
                    </a>

                    {{-- for individual page --}}

                    {{-- <a href="{{ route('home.filteredByBrandProducts', str_replace(' ', '-', $brand->name)) }}"
                        class="text-decoration-none">
                        <div class="text-center mx-4">
                            <img src="{{ $brand->image }}" class="img-thumbnail rounded-circle object-fit-cover mb-2"
                                style="width: 150px; height: 150px;">
                            <div class="fw-bold fs-5 text-dark">{{ $brand->name }}</div>
                        </div>
                    </a> --}}
                @endforeach
            </div>
        </marquee>
    </div>
    <!-- Brand Section End -->
@endsection
