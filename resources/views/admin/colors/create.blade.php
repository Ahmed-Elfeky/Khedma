@extends('admin.layouts.master')
@section('title','Color')
@section('subTitle','create')

@section('content')
<div class="container">
    <h3>Add New Color</h3>
    <form action="{{ route('admin.colors.store') }}" method="POST">
        @csrf
         <div class="mb-3">
            <label class="form-label">color name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="اسم اللون (اختياري)">
        </div>

        <div class="mb-3">
            <label class="form-label"> color code (Hex)</label>
            <input type="color" name="hex" class="form-control form-control-color" value="{{ old('hex', '#000000') }}">
            @error('hex') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
