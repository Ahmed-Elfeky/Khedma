@extends('admin.layouts.master')
@section('title','sub Category')
@section('subTitle','update')

@section('content')
<div class="container">
    <h3>Update Sub Category</h3>
    <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{old('name', $city->name)}}" class="form-control">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">shipping price </label>
            <input type="number" step="0.01" name="shipping_price" class="form-control"
                value="{{ old('shipping_price',$city->shipping_price) }}">
            @error('shipping_price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>

@endsection
