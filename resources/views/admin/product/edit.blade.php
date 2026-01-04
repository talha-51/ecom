@extends('layouts.backend.master')

@section('title')
    Edit Product
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Product</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Product</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-md-6"> {{-- half width and centered --}}
                <div class="card shadow p-4">
                    <h5 class="card-title mb-3 text-center">Edit Product Details</h5>

                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" readonly class="form-control" value="{{ $product->id }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                            @error('name')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="{{ $product->price }}">
                            @error('price')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" name="quantity" class="form-control" value="{{ $product->quantity }}">
                            @error('quantity')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($product->image)
                            <div class="mb-3 text-center">
                                <label class="form-label d-block">Current Image</label>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
                                    width="150">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload New Image</label>
                            <input type="file" class="form-control" id="image" name="image"
                                placeholder="Upload Image">
                            @error('image')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="cat_name" class="form-label">Category Name</label>
                            <select class="form-select" name="cat_id" aria-label="Default select example">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="cat_name" class="form-label">Sub-Category Name</label>
                            <select class="form-select" name="sub_id" aria-label="Default select example">
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="brand_name" class="form-label">Brand Name</label>
                            <select class="form-select" name="brand_id" aria-label="Default select example">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
