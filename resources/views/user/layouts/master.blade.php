<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    @include('user.layouts.head-tag')
    @yield('head-tag')
</head>

<body>
    <!-- Page Loader -->
    @include('user.layouts.page-loader')
    @include('user.layouts.header')
    @yield('banner')
    <div class="container-fluid tm-container-content tm-mt-60">
        @yield('content')
    </div>
    @include('user.layouts.footer')

    <div class="parentLoaderAjax" id="parentLoader" style="display: none;">
        <div class="loader"></div>
    </div>

    @include('user.layouts.script')
    @yield('script')



    @include('alerts.sweetalerts.success')
    @include('alerts.sweetalerts.error')
    <section class="toast-wrapper flex-row-reverse">
        @include('alerts.toast.success')
        @include('alerts.toast.error')
    </section>

</body>

</html>
