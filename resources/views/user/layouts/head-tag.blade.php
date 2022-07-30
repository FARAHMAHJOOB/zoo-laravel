<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('user-assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('general-assets/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('general-assets/sweetalert/sweetalert2.min.css') }}" />
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('user-assets/errors/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('user-assets/css/templatemo-style.css') }}">
<link rel="stylesheet" href="{{ asset('user-assets/auth/login.css') }}">
@livewireStyles
