<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <img src="{{ asset($setting->icon) }}" alt="" class=" rounded" style="height: 100px">
        <h1 class="mx-3 font-weight-bold">{{ $setting->title }}</h1>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 navbar-mobile-view">
                <li class="nav-item">
                    <a class="nav-link nav-link-1 {{ activeLink('/') }}" aria-current="page"
                        href="{{ route('home') }}">صفحه اصلی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-1 {{ activeLink('categories') }}"
                        href="{{ route('categories') }}">دسته
                        بندی</a>
                </li>
                @foreach ($menus as $menu)
                    <li class="nav-item" style="position: relative">
                        <a class="nav-link nav-link-1 {{ activeLink($menu->url) }}  {{ $menu->childs()->exists() ? 'dropdown-toggle d-flex align-items-center' : '' }}"
                            href="{{ $menu->url }}"
                            @if ($menu->childs()->exists()) data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @endif
                            id="dropdownMenuBtn{{ $menu->id }}">{{ $menu->name }}</a>
                        <section class="dropdown-menu py-0 dropdown-menu-right" style="position: absolute;"
                            aria-labelledby="dropdownMenuBtn{{ $menu->id }}">
                            <section class="list-group rounded text-right shadow">
                                @foreach ($menu->childs as $child)
                                    <a href="{{ $child->url }}" class="list-group-item list-group-item-action">
                                        {{ $child->name }}
                                    </a>
                                @endforeach
                            </section>
                        </section>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a class="nav-link nav-link-1 {{ activeLink('faqs') }}" href="{{ route('faqs') }}">سوالات
                        متداول</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-1" href="{{ route('faqs') }}">درباره</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-1" href="{{ route('faqs') }}">ارتباط با
                        ما</a>
                </li>
            </ul>
        </div>
        @auth

            <div class="page__container pointer" id="dropdownUserProfileButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <div class="page__demo ">
                    <span class="page__caption dropdown-toggle d-flex flex-row-reverse align-items-center">
                    </span>
                    <a href="" class="mask mask_type1 mask_type1-a1 page__tile">
                        <img src="{{ asset(Auth::user()->profile_photo_path ?? 'images/users/defultProfile.png') }}"
                            class="mask__img userImage" alt="avatar">
                    </a>
                </div>
            </div>
            <section class="dropdown-menu pt-0 pb-2 ml-2 mt-0" aria-labelledby="dropdownUserProfileButton">
                <section class="rounded bg-white text-right px-2">
                    <a href="{{ route('user.account.dashboard') }}"
                        class="dropdown-item font-weight-bold py-2 d-flex align-items-center">
                        <i class="fa fa-angle-right ml-2"></i>

                        {{ Auth::user()->showAvatarName }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item py-2">
                        <i class="fas fa-cog ml-2"></i>تنظیمات
                    </a>
                    <a href="#" class="dropdown-item py-2">
                        <i class="fas fa-user ml-2"></i>کاربر
                    </a>
                    <a href="#" class="dropdown-item py-2">
                        <i class="far fa-envelope ml-2"></i>پیام ها
                    </a>
                    
                    <a href="{{ route('auth.user.logout') }}" class="dropdown-item py-2">
                        <i class="fas fa-sign-out-alt ml-2"></i>خروج
                    </a>

                </section>
            </section>
        @endauth
        @guest
            <a href="{{ route('auth.user.login-register-form') }}"
                class="btn btn-primary py-1 px-1 login-register-btn">ورود/ ثبت نام</a>
        @endguest
    </div>
</nav>
