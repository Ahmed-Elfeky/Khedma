<!doctype html>
<html lang="en">
<!--begin::Head-->
@include('dashboard.layouts.header')
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('dashboard.layouts.mainheader')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('dashboard.layouts.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
          @include('dashboard.layouts.content-header')
            <!--end::App Content Header-->
            <!--begin::App Content-->
           @yield('content')
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        @include('dashboard.layouts.footer')
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    @include('dashboard.layouts.script')
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
