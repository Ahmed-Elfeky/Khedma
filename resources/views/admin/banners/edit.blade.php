@extends('admin.layouts.master')
@section('title','Banners')
@section('subTitle','update')

@section('content')
<div class="container">
    <h2>Edit Banner</h2>
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="desc" class="form-control">{{ old('desc', $banner->desc) }}</textarea>
            @error('desc') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Current Image</label><br>
            <img src="{{ asset('uploads/banners/' . $banner->image) }}" width="150" class="mb-2"><br>
            <label>Change Image (optional)</label>
            <input type="file" name="image" class="form-control">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('previewContainer');
        if (file) {
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endsection
