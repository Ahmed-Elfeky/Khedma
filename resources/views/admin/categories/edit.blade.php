@extends('admin.layouts.master')
@section('title','Category')
@section('subTitle','update')

@section('content')
<div class="container">
    <h3>Update Category</h3>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{old('name', $category->name)}}" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="desc" class="form-control"> {{old('desc', $category->desc)}} </textarea>
            @error('desc')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- عرض الصورة الحالية -->
        <div class="mb-3">
            <label class="form-label d-block">Current Image</label>
            @if ($category->image)
            <img id="current-image" src="{{ asset('uploads/categories/' . $category->image) }}" alt="Current Image"
                width="150" class="rounded border p-1">
            @else
            <p class="text-muted">No image uploaded.</p>
            @endif
        </div>
        <!-- رفع صورة جديدة -->
        <div class="mb-3">
            <label for="image" class="form-label">Change Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*"
                onchange="previewImage(event)">
        </div>

        <!-- معاينة الصورة الجديدة -->
        <div class="mb-3" id="preview-container" style="display:none;">
            <label class="form-label d-block">New Image Preview</label>
            <img id="preview" src="#" alt="Preview" width="150" class="rounded border p-1">
        </div>

        <button class="btn btn-success">Update</button>
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
