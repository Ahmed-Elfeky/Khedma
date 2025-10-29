@extends('admin.layouts.master')
@section('title', 'Orders')
@section('subTitle', 'All Orders')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">قائمة الطلبات</h5>
            <i class="fas fa-boxes"></i>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>الحالة الحالية</th>
                            <th>تغيير الحالة</th>
                            <th>الإجمالي</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'غير معروف' }}</td>
                            <td>
                                <span class="badge
                                @if($order->status == 'pending') bg-warning text-dark
                                @elseif($order->status == 'processing') bg-info text-dark
                                @elseif($order->status == 'delivered') bg-success
                                @elseif($order->status == 'canceled') bg-danger
                                @endif">
                                    {{ __($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <select name="status" class="form-select form-select-sm w-auto order-status"
                                        data-id="{{ $order->id }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد
                                            الانتظار</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' :
                                            ''}}>قيد المعالجة</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : ''
                                            }}>تم التسليم</option>
                                    </select>
                                </div>
                            </td>
                            <td>{{ number_format($order->total, 2) }} جنيه</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> تفاصيل
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">لا توجد طلبات حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.order-status').forEach(select => {
    select.addEventListener('change', function() {
        const orderId = this.dataset.id;
        const newStatus = this.value;

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: `سيتم تغيير حالة الطلب إلى "${newStatus}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تحديث',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/orders/${orderId}/update-status`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحديث بنجاح ✅',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'حدث خطأ!',
                            text: data.message || 'تعذر تحديث الحالة'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'فشل الاتصال!',
                        text: 'تأكد من الاتصال بالخادم.'
                    });
                });
            } else {
                // لو لغى التأكيد، يرجّع القيمة القديمة
                window.location.reload();
            }
        });
    });
});
</script>

@endsection
@endsection
