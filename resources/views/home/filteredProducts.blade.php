@extends('layouts.frontend.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    {{-- Category type: show marquee --}}
    @if ($type === 'category' && $subcategories->isNotEmpty())
        <div class="container-fluid mt-4">
            <div class="container-fluid text-center">
                <h1 class="mb-5">Sub-Categories</h1>
            </div>
            <marquee class="mt-2" scrollamount="10" width="100%" direction="left" height="220px">
                <div class="d-flex">
                    @foreach ($subcategories as $subcategory)
                        <a href="{{ route('home.filteredProducts', ['type' => 'sub-category', 'name' => str_replace(' ', '-', $subcategory->name)]) }}"
                            class="text-decoration-none">
                            <div class="text-center mx-4">
                                <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                                    class="img-thumbnail rounded-circle object-fit-cover mb-2"
                                    style="width: 150px; height: 150px;">
                                <div class="fw-bold fs-5 text-dark">{{ $subcategory->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </marquee>
        </div>
    @endif

    {{-- Products Section --}}
    <div class="container text-center mt-4 mb-5">
        <h1 class="mb-5">{{ $title }}</h1>

        <div class="row">
            @forelse ($filteredProducts as $product)
                <div class="col-md-3 mb-3">
                    <div class="card h-100">
                        <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body bg-primary-subtle text-primary-emphasis">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }}</p>
                            <div class="text-center">
                                <form action="{{ route('cart.addToCart', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success">Add to Cart</button>
                                </form>

                                <form action="{{ route('cart.onepagecheckout', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products found for this {{ $type }}.</p>
            @endforelse
        </div>
    </div>
@endsection
