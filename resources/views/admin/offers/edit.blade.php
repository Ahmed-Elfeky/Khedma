@extends('admin.layouts.master')
@section('title', 'تعديل العرض')

@section('content')
<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">تعديل العرض</h4>
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

            <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">القسم</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">اختر القسم</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $offer->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">عنوان العرض</label>
                    <input type="text" name="title" class="form-control" value="{{ $offer->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description" class="form-control" rows="3">{{ $offer->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">نوع الخصم</label>
                    <select name="type" class="form-select" required>
                        <option value="percentage" {{ $offer->type == 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                        <option value="fixed" {{ $offer->type == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (جنيه)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">قيمة الخصم</label>
                    <input type="number" step="0.01" name="value" class="form-control" value="{{ $offer->value }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ البداية</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $offer->start_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ النهاية</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $offer->end_date }}" required>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ $offer->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">تفعيل العرض الآن</label>
                </div>

                <button type="submit" class="btn btn-warning text-white">تحديث</button>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">رجوع</a>
            </form>
        </div>
    </div>
</div>
@endsection
