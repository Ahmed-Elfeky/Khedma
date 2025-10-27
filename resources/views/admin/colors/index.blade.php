@extends('admin.layouts.master')
@section('title','Color')
@section('subTitle','index')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Colors</h3>
        <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">+ Add Color</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>name</th>
                <th> hex</th>
                <th> color</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
            @forelse($colors as $color)
            <tr>
                <td>{{ $color->id }}</td>
                <td>{{ $color->name }}</td>
                <td>{{ $color->hex }} </td>
                <td>
                    <div style="width:40px;height:25px;border:1px solid #ccc;background:{{ $color->hex }}"></div>
                </td>
                <td>
                    <a href="{{ route('admin.colors.edit', $color->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                    <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('هل أنت متأكد من حذف اللون ؟')"
                            class="btn btn-sm btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">لا توجد الوان مسجلة بعد</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $colors->links() }}
</div>
@endsection
