@extends('admin.layouts.master')
@section('title','product')
@section('subTitle','create')
@section('content')
<div class="container">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="subcategory_id" class="form-control">
                <option value="">-- Select --</option>
                @foreach($subcategories as $sub)
                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ old('stock') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Discount (%)</label>
            <input type="number" step="0.01" name="discount" value="{{ old('discount') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Guarantee</label>
            <input type="text" name="guarantee" value="{{ old('guarantee') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="desc" rows="3" class="form-control">{{ old('desc') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Additional Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <small class="text-muted">You can select multiple images</small>
            @error('images') <small class="text-danger">{{ $message }}</small> @enderror
            @error('images.*') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Colors</label>
            <select name="colors[]" multiple class="form-control">
                @foreach($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sizes</label>
            <select name="sizes[]" multiple class="form-control">
                @foreach($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Product Owner (User)</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
