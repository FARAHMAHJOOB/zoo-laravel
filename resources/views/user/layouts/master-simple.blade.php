<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    @include('user.auth.layouts.head-tag')
    @yield('head-tag')
</head>
<body>


    <div class="container-fluid tm-container-content">

    @yield('content')

    </div>





    @include('user.auth.layouts.script')
    @yield('script')
</body>
</html>
