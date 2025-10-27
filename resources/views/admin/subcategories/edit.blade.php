@extends('admin.layouts.master')
@section('title','sub Category')
@section('subTitle','update')

@section('content')
<div class="container">
    <h3>Update Sub Category</h3>
    <form action="{{ route('admin.subcategories.update', $subcat->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{old('name', $subcat->name)}}" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Parent Category</label>
            <select name="category_id" class="form-control" required>
                <option value=""></option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $subcat->category_id == $category->id ? 'selected':'' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
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
