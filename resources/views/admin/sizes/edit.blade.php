@extends('admin.layouts.master')
@section('title','sub Category')
@section('subTitle','update')

@section('content')
<div class="container">
    <h2>Edit Size</h2>

    <form action="{{ route('admin.sizes.update', $size) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $size->name) }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
