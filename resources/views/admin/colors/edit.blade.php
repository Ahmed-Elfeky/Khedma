@extends('admin.layouts.master')
@section('title','Color')
@section('subTitle','update')

@section('content')
<div class="container">
    <h3>Update Color</h3>
    <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{old('name', $color->name)}}" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label"> color code (Hex)</label>
            <input type="color" name="hex" class="form-control form-control-color"
                value="{{ old('hex', $color->hex) }}">
            @error('hex') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>

@endsection
