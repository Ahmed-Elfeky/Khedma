@extends('admin.layouts.master')
@section('title','SubCategory')
@section('subTitle','create')

@section('content')
<div class="container">
    <h3>Add New Category</h3>
    <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Parent Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected':'' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
