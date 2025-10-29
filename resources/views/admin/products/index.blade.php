@extends('admin.layouts.master')
@section('title','product')
@section('subTitle','index')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>All Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Subcategory</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->subCategory?->name }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->image)
                    <img src="{{ asset('uploads/products/' . $product->image) }}" width="60" height="50">
                    @else
                    <span class="text-muted"> No Image </span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary btn-sm">Show</a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $product->id }}">
                        حذف
                    </button>

                    <form id="delete-form-{{ $product->id }}"
                        action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من استرجاع المنتج بعد الحذف!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
});
</script>

@endsection
@endsection
