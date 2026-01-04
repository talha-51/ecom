@extends('layouts.backend.master')

@section('title')
    Sliders
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Slider</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Slider</li>
        </ol>

        <div class="d-grid gap-2 mb-4">
            <button class="btn btn-lg btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Add New Slider</button>
        </div>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Added By</th>
                    <th>Updated By</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($sliders as $slider)
                    <tr>
                        <td>{{ $slider->id }}</td>
                        <td>{{ $slider->title }}</td>
                        <td>
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->image }}" class="img-thumbnail"
                                width="100">
                        </td>
                        <td>{{ optional($users->firstWhere('id', $slider->added_by_id))->name }}</td>
                        <td>{{ optional($users->firstWhere('id', $slider->updated_by_id))->name }}</td>
                        {{-- <td>{{ $slider->added_by_id }}</td>
                        <td>{{ $slider->updated_by_id }}</td> --}}
                        <td>
                            <button class="btn btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $slider->id }}">Edit
                            </button>
                            <form action="{{ route('slider.destroy', $slider->id) }}" method="POST" class="d-inline">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Slider</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
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

    <!-- Edit Modal -->
    @foreach ($sliders as $slider)
        <div class="modal fade" id="editModal{{ $slider->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Slider</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-body">

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $slider->title }}">
                                @error('title')
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
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script to reopen create-modal if validation fails -->
    @if ($errors->any() && session('form') === 'create')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var createModal = new bootstrap.Modal(document.getElementById('createModal'));
                createModal.show();
            });
        </script>
    @endif

    <!-- Script to reopen edit-modal if validation fails -->
    @if ($errors->any() && session('edit_slider_id'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editModal = new bootstrap.Modal(document.getElementById(
                    'editModal{{ session('edit_slider_id') }}'));
                editModal.show();
            });
        </script>
    @endif
@endsection
