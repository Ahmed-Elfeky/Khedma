@extends('admin.layouts.master')
@section('title','Banners')
@section('subTitle','index')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Banners</h3>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Add Banner +</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ Str::limit($banner->desc, 50) }}</td>
                    <td><img src="{{ asset('uploads/banners/' . $banner->image) }}" width="60" height="60"  ></td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $banners->links() }}
</div>
@endsection
