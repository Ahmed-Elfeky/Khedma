<!doctype html>
<html lang="en">
<!--begin::Head-->
@include('admin.layouts.header')
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('admin.layouts.mainheader')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('admin.layouts.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
          @include('admin.layouts.content-header')
            <!--end::App Content Header-->
            <!--begin::App Content-->
           @yield('content')
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        @include('admin.layouts.footer')
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    @include('admin.layouts.script')
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
