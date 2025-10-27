@extends('admin.layouts.master')
@section('title','Category')
@section('subTitle','create')

@section('content')
<div class="container">
    <h2>Add Banner</h2>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="desc" class="form-control">{{ old('desc') }}</textarea>
            @error('desc') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
