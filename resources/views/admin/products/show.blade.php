@extends('admin.layouts.master')
@section('title','show')
@section('subTitle','show product')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">تفاصيل المنتج</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted mb-1">الاسم:</h6>
                    <p class="fw-bold">{{ $product->name }}</p>

                    <h6 class="text-muted mb-1">الوصف:</h6>
                    <p>{{ $product->desc }}</p>

                    <h6 class="text-muted mb-1">السعر:</h6>
                    <p class="fw-bold text-success">{{ $product->price }} جنيه</p>

                    <h6 class="text-muted mb-1">المخزون:</h6>
                    <p>{{ $product->stock }}</p>

                    <h6 class="text-muted mb-1">الخصم:</h6>
                    <p>{{ $product->discount }}%</p>
                </div>

                <div class="col-md-6 text-center">
                    <h6 class="text-muted mb-3">صورة المنتج الرئيسية:</h6>
                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                         alt="صورة المنتج"
                         class="img-fluid rounded border shadow-sm mb-3"
                         style="max-width: 250px;">
                </div>
            </div>

            <hr>

            <h6 class="text-muted mb-3">صور إضافية:</h6>
            @if ($product->images && $product->images->count() > 0)
                <div class="row g-3">
                    @foreach ($product->images as $img)
                        <div class="col-6 col-md-3">
                            <div class="card border-0 shadow-sm">
                                <img src="{{ asset('uploads/products/' . $img->image) }}"
                                     alt="صورة إضافية" width="40" height="100"
                                     class="card-img-top rounded">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">لا توجد صور إضافية</p>
            @endif
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary px-4">
                <i class="bi bi-arrow-left"></i> رجوع
            </a>
        </div>
    </div>
</div>

@endsection
