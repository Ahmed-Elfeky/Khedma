@extends('layouts.master')
@section('content')
    {{-- رسائل نجاح
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Get 24/7 Support</p>
                        <h3 style="color: white"><span class="orange-text">All</span> Products</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item ">
                            <div class="product-image">
                                <a href="{{ route('front.products.detailes', $product->slug) }}"><img width="250px"
                                        height="250px" src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $product->name }}"></a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price"><span>{{ $product->description }}</span> {{ $product->price }}$
                            </p>
                            <form action="{{ route('front.cart.add', $product->slug) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Add to
                                    Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
                {{-- أزرار التنقل بين الصفحات --}}
                <div style="text-align: center; margin: 50px auto ; ">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- end product section -->
@endsection
