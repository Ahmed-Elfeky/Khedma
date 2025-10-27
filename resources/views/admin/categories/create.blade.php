@extends('admin.layouts.master')
@section('title','Category')
@section('subTitle','create')

@section('content')
<div class="container">
    <h3>Add New Category</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="desc" class="form-control"></textarea>
            @error('desc')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
