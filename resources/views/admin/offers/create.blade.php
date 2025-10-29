@extends('admin.layouts.master')
@section('title', 'إضافة عرض جديد')

@section('content')
<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">إضافة عرض جديد</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.offers.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">القسم</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">اختر القسم</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">عنوان العرض</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">نوع الخصم</label>
                    <select name="type" class="form-select" required>
                        <option value="percentage">نسبة مئوية (%)</option>
                        <option value="fixed">مبلغ ثابت (جنيه)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">قيمة الخصم</label>
                    <input type="number" step="0.01" name="value" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ النهاية</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="is_active" value="1" checked>
                    <label class="form-check-label">تفعيل العرض الآن</label>
                </div>

                <button type="submit" class="btn btn-success">حفظ العرض</button>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>
        </div>
    </div>
</div>
@endsection
