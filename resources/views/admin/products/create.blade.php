@extends('layouts.master')

@section('content')



    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Add Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- products -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="contact-form">
                <form method="POST" action="{{ route('front.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <p>
                        <input type="text" style="width: 100%" placeholder="Name" value="{{ old('name') }}"
                            name="name">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </p>
                    <p style="display: flex">
                        <input type="number" class="mr-4" style="width: 50%" placeholder="price" name="price"
                            value="{{ old('price') }}">
                        @error('price')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror

                    <input type="number" style="width:50%" placeholder="quantity" name="quantity"
                        value="{{ old('quantity') }}" id="quantity">
                    @error('quantity')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                    </p>
                    <p>
                        <select id="category" class="form-control" style="width: 100%" name="category_id">
                            <option value=""> select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div style="color:red;">{{ $message }}</div>
                    @enderror
                    </p>

                       <div class="mb-3">
                            <label>Subcategory:</label>
                            <select name="subcategory_id" id="subcategory" class="form-control">
                                <option value="">-- Select Subcategory --</option>
                            </select>
                        </div>

                    <p>
                        <textarea name="description" id="description" cols="30" rows="10"> {{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </p>
                    <p>
                        <label> select Images</label>
                        <input class="form-control" type="file" placeholder="image" name="image" required>
                        @error('image')
                        <p class="alert alert-danger">{{ $message }}</p>
                    @enderror
                    </p>

                    <div class="mb-3">
                        <label> select multi Images</label>
                        <input type="file" name="images[]" class="form-control" multiple required>
                        @error('images')
                            <p class="alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <p>
                        <button type="submit" class="btn btn-danger">save</button>
                    </p>
                </form>
            </div>
        </div>
    </div>


<script>
    let categories = @json($categories);
    document.getElementById('category').addEventListener('change', function() {
        let catId = this.value;
        let subSelect = document.getElementById('subcategory');
        subSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';

        let selectedCat = categories.find(cat => cat.id == catId);
        if (selectedCat && selectedCat.subcategories) {
            selectedCat.subcategories.forEach(sub => {
                subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        }
    });
</script>



@endsection
