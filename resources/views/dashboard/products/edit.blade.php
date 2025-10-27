@extends('layouts.master')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Edit Product</h1>
                        <p>Lorem ipsum dolor sit amet beatae optio.</p>
                    </div>
                </div>
            </div>
            {{-- رسائل فشل عامة --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    Please fix the errors below.
                </div>
            @endif

            <div class="contact-form">
                <form method="POST" action="{{ route('front.products.update', $product->slug) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <p>
                        <input type="text" style="width: 100%" placeholder="Name"
                            value="{{ old('name', $product->name) }}" name="name">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </p>
                    <p style="display: flex">
                        <input type="number" value="{{ old('price', $product->price) }}" class="mr-4" style="width: 50%"
                            placeholder="price" name="price" value="{{ old('price') }}">
                        @error('price')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror

                    <input type="number" value="{{ old('quantity', $product->quantity) }}" style="width:50%"
                        placeholder="quantity" name="quantity" value="{{ old('quantity') }}" id="quantity">
                    @error('quantity')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                    </p>
                    <p>
                        <select class="form-control" style="width: 100%" name="category_id">
                            <option value=""> select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div style="color:red;">{{ $message }}</div>
                    @enderror
                    </p>
                    <p>
                        <textarea name="description" id="description" cols="20" rows="10"> {{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </p>

                    <div class="mb-3">
                        <input type="file" name="image" class="form-control" id="imageInput">
                    </div>
                    <div class="mb-3">
                        <img id="imagePreview" src="{{ asset('uploads/products/' . $product->image) }}" width="80"
                            height="80" style="object-fit: cover; border:1px solid #ccc; border-radius:5px;">
                    </div>
                    <div class="form-group mb-3">
                        <label style="color: white" for="images">Additional Images</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <div class="mt-3 d-flex flex-wrap gap-2">
                            @foreach ($product->images as $image)
                                <div id="image-wrapper-{{ $image->id }}" class="mb-2">
                                    <img src="{{ asset('uploads/products/' . $image->image) }}"
                                        id="image-{{ $image->id }}" width="100">
                                    <button class="btn btn-sm btn-danger image_delete" data-id="{{ $image->id }}"
                                        data-url="{{ route('front.products.deleteImage', $image->id) }}">
                                        حذف
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p>
                        <button type="submit" class="btn btn-danger">update</button>
                    </p>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $(".image_delete").click(function(e) {
            e.preventDefault();

            var item = $(this).data('id');
            var url = $(this).data('url');

            $.ajax({
                type: "POST", // خليها POST
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(result) {
                    if (result.success) {
                        $('#image-wrapper-' + item).remove();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Error deleting image');
                }
            });
        });
    });

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            imagePreview.src = URL.createObjectURL(file);
        }
    });
</script>
