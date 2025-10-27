@extends('admin.layouts.master')
@section('title','City')
@section('subTitle','index')

@section('content')
<div class="container py-4">
       <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Cities</h3>
        <a  href="{{ route('admin.cities.create') }}"class="btn btn-primary">+ Add City</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>سعر الشحن</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->shipping_price }} LE </td>
                    <td>
                        <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('هل أنت متأكد من حذف المدينة ؟')" class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">لا توجد مدن مسجلة بعد</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $cities->links() }}
</div>
@endsection

