@extends('admin.layouts.master')
@section('title','City')
@section('subTitle','index')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Cities</h3>
        <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary">+ Add Size</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sizes as $size)
            <tr>
                <td>{{ $size->id }}</td>
                <td>{{ $size->name }}</td>
                <td>
                    <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.sizes.destroy', $size) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sizes->links() }}
</div>
@endsection
