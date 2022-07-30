<div class="col-12 col-md-3 shadow-sm border right-side-account-dashboard px-0">
    <div class="col-12 d-flex flex-column haeder-right-side-account-dashboard">
        <section class="account-image col-4" id="account-image">
            <img src="{{ asset(Auth::user()->profile_photo_path ?? 'images/users/defultProfile.png') }}"
                alt="profilePhoto" class="shadow-lg userImage border" onclick="changeImage()">
            <div class="account-image-overlay" id="account-image-overlay">
                <form method="POST" enctype="multipart/form-data" id="frmEditProfilePhoto">
                    @csrf
                    <label for="profile_photo_path" class="pointer"><i
                            class="fa fa-edit account-image-icon"></i></label>
                    <input type="file" id="profile_photo_path" name="profile_photo_path" class="account-image-input">
                </form>
            </div>
        </section>
        <h4 class="w-auto mx-auto mb-4">{{ Auth::user()->showAvatarName }}</h4>
    </div>
    <div class="col-12 d-flex flex-column my-4 px-4 body-right-side-account-dashboard">
        <a href="{{ route('user.account.dashboard') }}" class="py-2 {{ activeLink('user/account/dashboard') }}">
           داشبورد
        </a>
        {{-- <a href="{{ route('user.account.edit-account-form') }}"
            class="py-2 {{ activeLink('user/account/edit-account-form') }}">
            <i class="fas fa-cog ml-2"></i>ویرایش حساب کاربری
        </a> --}}
        <a href="{{ route('auth.user.logout') }}" class="py-2">
            خروج از حساب کاربری
        </a>
    </div>
</div>
