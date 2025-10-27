@extends('admin.layouts.master')
@section('title','Sub Category')
@section('subTitle','index')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Sub Categories</h3>
        <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">Add New</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subcat as $cat)


            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->category->name }}</td>
                <td>
                    <a href="{{ route('admin.subcategories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.subcategories.destroy', $cat->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this sub category ?')">Delete</button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    {{ $subcat->links() }}
</div>
@endsection
