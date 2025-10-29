@extends('admin.layouts.master')
@section('title','show')
@section('subTitle','show product')
@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-body">
            <h5>الاسم:</h5>
            <p>{{ $product->name }}</p>

            <h5>الوصف:</h5>
            <p>{{ $product->desc }}</p>

            <h5>السعر:</h5>
            <p>{{ $product->price }} جنيه</p>

            <h5>المخزون:</h5>
            <p>{{ $product->stock }}</p>

            <h5>الخصم:</h5>
            <p>{{ $product->discount }}%</p>

            <h5>صورة المنتج الرئيسية:</h5>
            <img src="{{ asset('uploads/products/' . $product->image) }}" alt="صورة المنتج" width="200"
                class="rounded border mb-3">

            <h5>صور إضافية:</h5>
            @if ($product->images && $product->images->count() > 0)
            <div class="d-flex flex-wrap gap-3">
                @foreach ($product->images as $img)
                <div style="width:120px;">
                    <img src="{{ asset('uploads/products/' . $img->image) }}" alt="صورة إضافية"
                        class="rounded border w-100">
                </div>
                @endforeach
            </div>
            @else
            <p class="text-muted">لا توجد صور إضافية</p>
            @endif

        </div>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">رجوع</a>
</div>
@endsection
