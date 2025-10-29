@extends('admin.layouts.master')
@section('title', 'Orders')
@section('subTitle', 'Orders Detailes')
@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">
                تفاصيل طلب رقم <span class="text-dark">#{{ $order->id }}</span>
            </h4>
            <span class="badge fs-6 px-3 py-2
                        @if ($order->status == 'pending') bg-warning text-dark
                        @elseif($order->status == 'processing') bg-info text-dark
                        @elseif($order->status == 'delivered') bg-success
                        @elseif($order->status == 'canceled') bg-danger
                        @else bg-secondary @endif">
                {{ __($order->status) }}
            </span>
        </div>
        {{-- بيانات العميل + تفاصيل الطلب --}}
        <div class="row gy-4">
            <div class="col-md-6">
                <h5 class="text-secondary mb-3">🧍‍♂️ بيانات العميل</h5>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item">
                        <strong>الاسم:</strong> {{ $order->user->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>البريد الإلكتروني:</strong> {{ $order->user->email ?? 'غير متوفر' }}
                    </li>
                    <li class="list-group-item">
                        <strong>الهاتف:</strong> {{ $order->user->phone ?? 'غير متوفر' }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-secondary mb-3">📦 تفاصيل الطلب</h5>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item">
                        <strong>المدينة:</strong> {{ $order->city->name ?? 'غير محددة' }}
                    </li>
                    <li class="list-group-item">
                        <strong>الشحن:</strong> {{ number_format($order->shipping_price, 2) }} جنيه
                    </li>
                    <li class="list-group-item">
                        <strong>تاريخ الإنشاء:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                    </li>
                </ul>
            </div>
        </div>
        {{-- المنتجات --}}
        <h5 class="mt-5 mb-3 text-secondary">🛒 المنتجات داخل الطلب</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center border">
                <thead class="table-primary">
                    <tr>
                        <th>الصورة</th>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('uploads/products/' . $product->image) }}" width="60" height="60"
                                class="rounded shadow-sm border">
                        </td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ number_format($product->pivot->price, 2) }} جنيه</td>
                        <td class="fw-bold text-success">
                            {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }} جنيه
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <h6><strong>إجمالي المنتجات:</strong>
                {{ number_format($order->products->sum(fn($p) => $p->pivot->quantity * $p->pivot->price), 2) }} جنيه
            </h6>
            <h6><strong>سعر الشحن:</strong> {{ number_format($order->shipping_price, 2) }} جنيه</h6>
            <h4 class="text-success fw-bold mt-2">
                <strong>الإجمالي الكلي:</strong> {{ number_format($order->total, 2) }} جنيه
            </h4>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank"
                class="btn btn-success rounded-pill px-4">
                🖨️ طباعة الطلب
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                ⬅️ رجوع
            </a>
        </div>
    </div>
    <h5 class="mt-5 mb-3">سجل تغييرات الحالة</h5>
    <table class="table table-striped table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>من</th>
                <th>إلى</th>
                <th> التحديث بواسطة</th>
                <th>التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($order->statusHistories as $history)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <span class="badge bg-secondary">{{ $history->old_status ?? '-' }}</span>
                </td>
                <td>
                    <span class="badge
                        @if ($history->new_status == 'pending') bg-warning text-dark
                        @elseif($history->new_status == 'processing') bg-info text-dark
                        @elseif($history->new_status == 'delivered') bg-success
                        @elseif($history->new_status == 'canceled') bg-danger @endif">
                        {{ $history->new_status }}
                    </span>
                </td>
                <td>{{ $history->user->name ?? 'الأدمن' }}</td>
                <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-muted py-3">لا يوجد تغييرات مسجلة بعد</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
