<aside id="sidebar" class="sidebar font-weight-bold">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle sidebar-link">
                    <i class="fas fa-feather icon"></i>
                    <span>حیوانات</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown mr-2">
                    <a href="{{route('admin.animal.index')}}" class="sidebar-link">
                        <i class="fa fa-paw"></i>
                        <span>حیوانات</span>
                    </a>
                    <a href="{{route('admin.animal.gallery.allGallery')}}" class="sidebar-link">
                        <i class="far fa-images"></i>
                        <span>گالری</span>
                    </a>
                    <a href="{{route('admin.animal.category.index')}}" class="sidebar-link">
                        <i class="fa fa-list-alt"></i>
                        <span>دسته بندی ها</span>
                    </a>
                    <a href="{{route('admin.animal.protectiveStatus.index')}}" class="sidebar-link">
                        <i class="fa fa-shield"></i>
                        <span>وضعیت حفاظتی</span>
                    </a>
                </section>
            </section>
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle sidebar-link">
                    <i class="fas fa-file icon"></i>
                    <span>محتوی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown mr-2">
                    <a href="{{ route('admin.content.menu.index') }}" class="sidebar-link">
                        <i class="fa fa-th-list"></i>
                        <span>منو</span>
                    </a>
                    <a href="{{ route('admin.content.slider.index') }}" class="sidebar-link">
                        <i class="fa fa-exchange"></i>
                        <span>اسلایدر</span>
                    </a>

                    <a href="{{ route('admin.content.page.index') }}" class="sidebar-link">
                        <i class="fa fa-indent"></i>
                        <span>پیج ساز</span>
                    </a>
                </section>
            </section>
            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle sidebar-link">
                    <i class="fas fa-users icon"></i>
                    <span>کاربران</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown mr-2">
                    <a href="{{ route('admin.manager.index') }}" class="sidebar-link">
                        <i class="fas fa-user-cog"></i>
                        <span>مدیران</span>
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                        <i class="fas fa-user-friends"></i>
                        <span>کاربران سایت</span>
                    </a>
                   <a href="{{ route('admin.role.index') }}" class="sidebar-link">
                        <i class="fas fa-shield-alt"></i>
                        <span>سطوح دسترسی</span>
                    </a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle sidebar-link">
                    <i class="fas fa-comments icon"></i>
                    <span>نظرات</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown mr-2">
                    <a href="{{ route('admin.comment.unseenComment') }}" class="sidebar-link">
                        <i class="fa fa-rocket"></i>
                        <span>نظرات خوانده نشده</span>
                    </a>
                    <a href="{{ route('admin.comment.index') }}" class="sidebar-link">
                        <i class="fa fa-comments"></i>
                        <span>تمام نظرات </span>
                    </a>
                </section>
            </section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle sidebar-link">
                    <i class="fa fa-bullhorn icon"></i>
                    <span>اطلاع رسانی</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown mr-2">
                    <a href="" class="sidebar-link">
                        <i class="fa fa-envelope"></i>
                        <span>اطلاعیه ایمیلی</span>
                    </a>
                    <a href="" class="sidebar-link">
                        <i class="fas fa-sms"></i>
                        <span>اطلاعیه پیامکی</span>
                    </a>
                </section>
            </section>
            <!-- <section class="sidebar-part-title">تنظیمات</section> -->
            <a href="{{ route('admin.setting.index') }}" class="sidebar-link">
                <i class="fas fa-cogs"></i>
                <span>تنظیمات</span>
            </a>
            <a href="{{ route('admin.faq.index') }}" class="sidebar-link">
                <i class="fa fa-question-circle"></i>
                <span>سوالات متداول</span>
            </a>

        </section>
    </section>
</aside>
