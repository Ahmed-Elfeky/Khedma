@extends('admin.layouts.master')
@section('title','Dashboard')
@section('subTitle','Home')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">لوحة التحكم</h4>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-light btn-sm fw-bold px-3">
                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                </button>
            </form>
        </div>




        <div class="card-body bg-light">
            <div class="text-center my-4">
                <h3 class="fw-bold text-dark mb-2">مرحبًا {{ Auth::user()->name }} 👋</h3>
                <p class="text-muted mb-0">نتمنى لك يومًا مثمرًا في لوحة التحكم</p>
            </div>

            <hr class="my-4">

            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <i class="bi bi-people fs-1 text-primary"></i>
                        <h5 class="mt-3">المستخدمين</h5>
                        <p class="text-muted mb-0">إدارة جميع المستخدمين</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <i class="bi bi-box-seam fs-1 text-success"></i>
                        <h5 class="mt-3">المنتجات</h5>
                        <p class="text-muted mb-0">إضافة وتعديل المنتجات</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <i class="bi bi-bar-chart-line fs-1 text-warning"></i>
                        <h5 class="mt-3">التقارير</h5>
                        <p class="text-muted mb-0">عرض إحصائيات النظام</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
