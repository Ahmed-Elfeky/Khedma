@extends('admin.layouts.master')
@section('title','Size')
@section('subTitle','create')

@section('content')
<div class="container">
    <h2>Add Size</h2>

    <form action="{{ route('admin.sizes.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="S / M / L">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.sizes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
