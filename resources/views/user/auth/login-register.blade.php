@extends('user.layouts.master-simple')
@section('title')
    ورود/ ثبت نام
@endsection

@section('content')
    <section class="row mt-5">
        <section class="login-wrapper border-primary-tm bg-light mx-auto col-10 col-md-3">
            <section class="login-logo">
                <img src="{{ asset($setting->icon) }}" alt="icon" class="">
            </section>
            <section class="login-title mx-2">ورود / ثبت نام</section>
            <section class="login-info mr-2">شماره موبایل یا پست الکترونیک خود را وارد کنید</section>
            <form action="{{ route('auth.user.login-register') }}" method="post">
                @csrf
                <section class="login-input-text mx-2 mb-4" id="inputLoginSection">

                    <input class="border rounded text-right px-2" type="text" name="id" value="{{ old('id') }}"
                        required placeholder="ایمیل یا شماره موبایل..."
                        oninvalid="this.setCustomValidity('شماره موبایل یا ایمیل را وارد کنید')"
                        oninput="this.setCustomValidity('')">
                    @error('id')
                        <span class="alert_required text-danger p-1 rounded " role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2 text-center"><button
                        class="btn btn-primary py-2 px-3 w-75">ورود</button>
                </section>
                <section class="login-terms-and-conditions mx-2"><a href="#">شرایط و قوانین</a> را خوانده ام و پذیرفته
                    ام
                </section>
            </form>
        </section>
    </section>
@endsection
