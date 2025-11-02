@extends('admin.layouts.master')
@section('title', 'العروض')

@section('content')
<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">قائمة العروض</h4>
            <a href="{{ route('admin.offers.create') }}" class="btn btn-dark btn-sm">+ عرض جديد</a>
        </div>

        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>القسم</th>
                        <th>العنوان</th>
                        <th>الخصم</th>
                        <th>الفترة</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $offer)
                    <tr>
                        <td>{{ $offer->id }}</td>
                        <td>{{ $offer->category->name }}</td>
                        <td>{{ $offer->title }}</td>
                        <td>
                            @if($offer->type == 'percentage')
                            {{ $offer->value }}%
                            @else
                            {{ $offer->value }} ج.م
                            @endif
                        </td>
                        <td>{{ $offer->start_date }} → {{ $offer->end_date }}</td>
                        <td>
                            @if($offer->is_active)
                            <span class="badge bg-success">نشط</span>
                            @else
                            <span class="badge bg-secondary">غير نشط</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.offers.edit', $offer->id) }}"
                                class="btn btn-sm btn-primary">تعديل</a>

                            <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العرض؟')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-muted">لا توجد عروض حالياً</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
