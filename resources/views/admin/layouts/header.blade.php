<header class="header-main">
    <section class="sidebar-header">
        <section class="d-flex justify-content-between flex-md-row-reverse px-2">
            <span id="sidebar-toggle-show" class="d-inline d-md-none pointer"><i class="fas fa-toggle-off toggle-off"></i></span>
            <span id="sidebar-toggle-hide" class="d-none d-md-inline pointer"><i class="fas fa-toggle-on toggle-on"></i></span>
            <span class="mr-2"><img class="logo w-75 mx-auto" src="{{ asset('admin-assets/images/zoo logo.png') }}" alt=""></span>


            <span class="d-md-none pointer" id="menu-toggle"><i class="fas fa-ellipsis-h"></i></span>
        </section>
    </section>
    <section class="body-header" id="body-header">
        <section class="d-flex justify-content-between">
            <section>
                <span id="full-screen" class="pointer p-1 d-none d-md-inline mr-5">
                    <i id="screen-compress" class="fas fa-compress d-none"></i>
                    <i id="screen-expand" class="fas fa-expand "></i>
                </span>
            </section>
            <section class="ml-5 font-weight-bold">
                <span class="ml-2 ml-md-4 position-relative">
                    <span id="header-notification-toggle" class="pointer">
                        <i class="far fa-bell"></i>
                        <sup class="badge badge-danger">
                        </sup>
                    </span>
                    <section id="header-notification" class="header-notifictation rounded">
                        <section class="d-flex justify-content-between">
                            <span class="px-2">
                                اعلانات
                            </span>
                            <span class="px-2">
                                <span class="badge badge-danger">جدید</span>
                            </span>
                        </section>

                        <ul class="list-group rounded px-0">
                            <li class="list-group-item list-group-item-action py-0">
                                <section class="media">
                                    <!-- <img class="notification-img" src="{{ asset('admin-assets/images/avatar-2.jpg') }}" alt="avatar"> -->
                                    <section class="media-body pr-1 border-bottom pt-2 pb-0">
                                        <p class="notification-text"></p>
                                        <p class="notification-time"></p>
                                    </section>
                                </section>
                            </li>
                        </ul>
                    </section>
                </span>
                <span class="ml-2 ml-md-4 position-relative">
                    <span id="header-comment-toggle" class="pointer">
                        <i class="far fa-comment-alt">
                            <sup class="badge badge-danger"></sup>
                        </i>
                    </span>
                    <section id="header-comment" class="header-comment">
                        <section class="d-flex justify-content-between">
                            <span class="px-2">
                                نظرات
                            </span>
                            <span class="px-2">
                                <span class="badge badge-danger">جدید</span>
                            </span>
                        </section>
                        <section class="header-comment-wrapper">
                            <ul class="list-group rounded px-0">
                                <li class="list-group-item list-groupt-item-action">
                                    <section class="media">
                                        <img src="" alt="avatar" class="notification-img">
                                        <section class="media-body pr-1">
                                            <section class="px-1" title="">
                                                <h5 class="comment-user text-dark"></h5>
                                                <h6 class="comment-user"></h6>
                                            </section>
                                        </section>
                                    </section>
                                </li>
                            </ul>
                        </section>
                    </section>
                </span>

                <span class="ml-3 ml-md-5 position-relative">
                    <span id="header-profile-toggle" class="pointer">
                        <img class="header-avatar" src="{{ asset(Auth::user()->profile_photo_path) }}" alt="">
                        <span class="header-username text-light">{{ Auth::user()->fullName }}</span>
                        <i class="fas fa-angle-down"></i>
                    </span>
                    <section id="header-profile" class="header-profile rounded w-100">
                        <section class="list-group rounded bg-white">
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-cog"></i>تنظیمات
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-user"></i>کاربر
                            </a>
                            <a href="#" class="list-group-item list-group-item-action header-profile-link">
                                <i class="far fa-envelope"></i>پیام ها
                            </a>
                            <a href="{{url('password/reset')}}" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-lock"></i>تغییر کلمه عبور
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                            <button type="submit" class="list-group-item list-group-item-action header-profile-link">
                                <i class="fas fa-sign-out-alt"></i>خروج
                            </button>
                            </form>
                        </section>
                    </section>
                </span>
            </section>

        </section>
    </section>
</header>
