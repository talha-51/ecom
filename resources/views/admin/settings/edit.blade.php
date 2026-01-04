@extends('layouts.backend.master')

@section('title')
    Edit Setting
@endsection

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Setting</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Edit Setting</li>
        </ol>

        <div class="row justify-content-center">
            <div class="col-md-6"> {{-- half width and centered --}}
                <div class="card shadow p-4">
                    <h5 class="card-title mb-3 text-center">Edit Setting Details</h5>

                    <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if ($setting->logo)
                            <div class="mb-3 text-center">
                                <label class="form-label d-block">Current Logo</label>
                                <img src="{{ asset($setting->logo) }}" alt="logo" class="img-thumbnail" width="200">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="logo" class="form-label">Upload Logo</label>
                            <input type="file" class="form-control" id="Logo" name="logo"
                                placeholder="Upload Logo">
                            @error('logo')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="favicon" class="form-label">Favicon</label>
                            <input type="text" name="favicon" class="form-control" value="{{ $setting->favicon }}">
                            @error('favicon')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ $setting->company_name }}">
                            @error('company_name')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $setting->email }}">
                            @error('email')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="contact_no" class="form-label">Contact NO</label>
                            <input type="text" name="contact_no" class="form-control" value="{{ $setting->contact_no }}">
                            @error('contact_no')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="facebook" class="form-label">Facebook Link</label>
                            <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                            @error('facebook')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="instagram" class="form-label">Instagram Link</label>
                            <input type="text" name="instagram" class="form-control" value="{{ $setting->instagram }}">
                            @error('instagram')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="youtube" class="form-label">Youtube Link</label>
                            <input type="text" name="youtube" class="form-control" value="{{ $setting->youtube }}">
                            @error('youtube')
                                <div class="alert alert-danger mt-2 text-center">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('settings.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
