@extends('admin.layouts.master')
@section('title','Category')
@section('subTitle','index')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Categories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->desc }}</td>
                <td>
                    @if($cat->image)
                    <img src="{{ asset('uploads/categories/' . $cat->image ) }}" width="60" height="60" class="rounded">
                    @else
                    <span class="text-muted"> No Image </span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No categories found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection
