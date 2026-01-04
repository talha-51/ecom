@extends('layouts.backend.master')

@section('title')
    Brands
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Brands</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Brands</li>
        </ol>

        <div class="d-grid gap-2 mb-4">
            <button class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add New Brand</button>
        </div>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Added By ID</th>
                    <th>Updated By ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Added By ID</th>
                    <th>Updated By ID</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->id }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail"
                                width="75">
                        </td>
                        <td>{{ optional($users->firstWhere('id', $brand->added_by_id))->name }}</td>
                        <td>{{ optional($users->firstWhere('id', $brand->updated_by_id))->name }}</td>
                        {{-- <td>{{ $brand->added_by_id }}</td>
                        <td>{{ $brand->updated_by_id }}</td> --}}
                        <td>
                            <a href="{{ route('brand.edit', $brand->id) }}"><button
                                    class="btn btn-outline-warning">Edit</button></a>
                            <form action="{{ route('brand.destroy', $brand->id) }}" method="POST" class="d-inline">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Brand</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
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
