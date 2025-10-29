@extends('admin.layouts.master')
@section('title','product')
@section('subTitle','Edit Product')
@section('content')
<div class="container">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">اسم المنتج</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">السعر</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}"
                step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">المخزون</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="desc" class="form-control" rows="4">{{ old('desc', $product->desc) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">الخصم (%)</label>
            <input type="number" name="discount" class="form-control" value="{{ old('discount', $product->discount) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">الضمان</label>
            <input type="text" name="guarantee" class="form-control"
                value="{{ old('guarantee', $product->guarantee) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">الصورة الرئيسية</label>
            <input type="file" name="image" class="form-control">

            @if ($product->image)
            <div class="mt-2">
                <img src="{{ asset('uploads/products/' . $product->image) }}" alt="main image" width="60"
                    class="rounded">
            </div>
            @endif
        </div>
        {{-- صور متعددة --}}
        <div class="mb-3">
            <label class="form-label">صور إضافية للمنتج</label>
            <input type="file" name="images[]" class="form-control" multiple >
            @if ($product->images->count() > 0)
            <div class="mt-3 d-flex flex-wrap gap-3">
                @foreach ($product->images as $img)
                <div class="position-relative image-box" data-id="{{ $img->id }}" style="width: 120px;">
                    <img src="{{ asset('uploads/products/' . $img->image) }}" class="rounded border w-100">
                    {{-- زر حذف الصورة --}}
                    <button type="button" class="btn btn-sm btn-danger delete-image-btn position-absolute top-0 end-0"
                        style="padding: 0 6px; border-radius: 50%;">
                        ×
                    </button>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- اختيار المستخدم (لو المنتج تابع لشركة) --}}
        <div class="mb-3">
            <label class="form-label">صاحب المنتج</label>
            <select name="user_id" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $product->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">الألوان</label>
            <select name="colors[]" class="form-control" multiple>
                @foreach ($colors as $color)
                <option value="{{ $color->id }}" {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ?
                    'selected' : '' }}>
                    {{ $color->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">المقاسات</label>
            <select name="sizes[]" class="form-control" multiple>
                @foreach ($sizes as $size)
                <option value="{{ $size->id }}" {{ in_array($size->id, $product->sizes->pluck('id')->toArray()) ?
                    'selected' : '' }}>
                    {{ $size->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">تحديث المنتج</button>
    </form>
</div>

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('.delete-image-btn').on('click', function() {
        if (!confirm('هل أنت متأكد من حذف هذه الصورة؟')) return;
        let button = $(this);
        let imageBox = button.closest('.image-box');
        let imageId = imageBox.data('id');

        $.ajax({
            url: "{{ url('admin/products/images') }}/" + imageId,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                // تأثير بسيط أثناء المعالجة
                button.prop('disabled', true).text('...');
                imageBox.css('opacity', '0.5');
            },
            success: function(response) {
                // حذف الصورة تدريجيًا (أنيميشن)
                imageBox.animate({ opacity: 0, transform: 'scale(0.9)' }, 400, function() {
                    $(this).slideUp(200, function() {
                        $(this).remove();
                    });
                });

                // تنبيه اختياري لطيف
                setTimeout(() => {
                    alert('✅ تم حذف الصورة بنجاح');
                }, 300);
            },
            error: function(xhr) {
                alert('❌ حدث خطأ أثناء حذف الصورة');
                imageBox.css('opacity', '1');
                button.prop('disabled', false).text('×');
            }
        });
    });
});
</script>


@endsection
@endsection
