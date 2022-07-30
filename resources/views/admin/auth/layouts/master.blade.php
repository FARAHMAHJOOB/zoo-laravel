<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>@yield('title')</title>
    @include('admin.auth.layouts.head-tag')
</head>
<body class="text-right">
	<div class="container-fluid">
	@yield('content')
	</div>
    @yield('script')
</body>
</html>
