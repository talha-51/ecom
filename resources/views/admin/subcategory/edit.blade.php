@extends('layouts.backend.master')

@section('title')
    Edit Sub-Category
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Sub-Category</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Sub-Category</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-md-6"> {{-- half width and centered --}}
                <div class="card shadow p-4">
                    <h5 class="card-title mb-3 text-center">Edit Sub-Category Details</h5>

                    <form action="{{ route('sub-category.update', $subcategory->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" readonly class="form-control" value="{{ $subcategory->id }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}">
                            @error('name')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <select class="form-select" name="cat_id" aria-label="Default select example">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($subcategory->image)
                            <div class="mb-3 text-center">
                                <label class="form-label d-block">Current Image</label>
                                <img src="{{ asset($subcategory->image) }}" alt="{{ $subcategory->name }}"
                                    class="img-thumbnail" width="200">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload New Image (optional)</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sub-category.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
