@extends('layouts.backend.master')

@section('title')
    Edit Brand
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Brand</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Brand</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-md-6"> {{-- half width and centered --}}
                <div class="card shadow p-4">
                    <h5 class="card-title mb-3 text-center">Edit Brand Details</h5>

                    <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" readonly class="form-control" value="{{ $brand->id }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $brand->name }}">
                            @error('name')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($brand->image)
                            <div class="mb-3 text-center">
                                <label class="form-label d-block">Current Image</label>
                                <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail"
                                    width="200">
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

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('brand.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
