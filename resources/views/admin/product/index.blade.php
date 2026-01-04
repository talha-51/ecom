@extends('layouts.backend.master')

@section('title')
    Products
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Products</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Products</li>
        </ol>

        <div class="d-grid gap-2 mb-4">
            <button class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add New
                Product</button>
        </div>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Sub-Category Name</th>
                    <th>Brand Name</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Sub-Category Name</th>
                    <th>Brand Name</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
                                width="75">
                        </td>
                        <td>{{ optional($categories->firstWhere('id', $product->cat_id))->name }}</td>
                        <td>{{ optional($subcategories->firstWhere('id', $product->sub_id))->name }}</td>
                        <td>{{ optional($brands->firstWhere('id', $product->brand_id))->name }}</td>
                        <td>{{ optional($users->firstWhere('id', $product->added_by_id))->name }}</td>
                        <td>{{ optional($users->firstWhere('id', $product->updated_by_id))->name }}</td>
                        {{-- <td>{{ $product->brand_id }}</td>
                        <td>{{ $product->cat_id }}</td>
                        <td>{{ $product->sub_id }}</td>
                        <td>{{ $product->added_by_id }}</td>
                        <td>{{ $product->updated_by_id }}</td> --}}
                        <td>
                            <a href="{{ route('product.edit', $product->id) }}"><button
                                    class="btn btn-outline-warning">Edit</button></a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf @method('delete')
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="{{ old('price') }}">
                            @error('price')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}">
                            @error('quantity')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image</label>
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Script to reopen create-modal if validation fails -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var createModal = new bootstrap.Modal(document.getElementById('createModal'));
                createModal.show();
            });
        </script>
    @endif
@endsection
