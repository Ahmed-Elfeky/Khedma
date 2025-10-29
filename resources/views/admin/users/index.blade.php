@extends('admin.layouts.master')
@section('title','Users')
@section('subTitle','index')
@section('content')
<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">قائمة المستخدمين</h4>
        </div>

        <div class="card-body">
            {{-- رسائل النجاح --}}
            @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            {{-- التبويبات --}}
            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                        type="button" role="tab">
                        المستخدمين العاديين
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="companies-tab" data-bs-toggle="tab" data-bs-target="#companies"
                        type="button" role="tab">
                        الشركات
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="userTabsContent">

                {{-- المستخدمين العاديين --}}
                <div class="tab-pane fade show active" id="users" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users->where('role', 'user') as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                            class="btn btn-sm btn-info text-white">
                                            <i class="bi bi-eye"></i> طلباته
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-muted">لا يوجد مستخدمين حاليًا</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- الشركات --}}
                <div class="tab-pane fade" id="companies" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>حالة الاعتماد</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users->where('role', 'company') as $company)
                                <tr>
                                    <td>{{ $company->id }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>
                                        @if ($company->is_approved)
                                        <span class="badge bg-success">معتمد</span>
                                        @else
                                        <span class="badge bg-warning text-dark">قيد المراجعة</span>
                                        @endif
                                    </td>
                                    <td>{{ $company->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        {{-- زر الاعتماد --}}
                                        @if(!$company->is_approved)
                                        <button class="btn btn-success btn-sm approve-btn" data-id="{{ $company->id }}">
                                            <i class="bi bi-check2-circle"></i> اعتماد
                                        </button>
                                        @else
                                        <span class="badge bg-success">معتمدة</span>
                                        @endif

                                        {{-- زر الحذف --}}
                                        <form action="{{ route('admin.users.destroy', $company->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-muted">لا توجد شركات حاليًا</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SweetAlert Script --}}
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const userId = this.dataset.id;

        Swal.fire({
            title: 'تأكيد اعتماد الشركة؟',
            text: "هل تريد اعتماد هذه الشركة الآن؟",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'نعم، اعتماد',
            cancelButtonText: 'إلغاء',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/users/${userId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire('تم الاعتماد!', data.message, 'success')
                        .then(() => location.reload());
                })
                .catch(() => {
                    Swal.fire('خطأ!', 'حدث خطأ أثناء العملية', 'error');
                });
            }
        });
    });
});
</script>

@endsection
@endsection
