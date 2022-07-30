@extends('user.layouts.master-simple')
@section('title')
    تاییدیه ورود
@endsection

@section('content')
    <section class="row mt-5">
        <section class="login-wrapper border-primary-tm bg-light mx-auto col-10 col-md-3">
            <section class="login-logo">
                <img src="{{ asset($setting->icon) }}" alt="icon" class="">
            </section>
            <section class="login-title mx-2"><a class="" href="{{ route('auth.user.login-register-form') }}" title="برگشت">برگشت
                </a>
            </section>
            <section class="login-info mr-2 font-weight-bold h4">کد تایید را وارد کنید</section>
            <section class="login-info mr-2 mb-2">
                @if ($otp->type == 0)
                    کد تایید برای شماره موبایل {{ $otp->login_id }} ارسال گردید
                @else
                    کد تایید برای ایمیل {{ $otp->login_id }} ارسال گردید
                @endif
            </section>
            <form action="{{ route('auth.user.login-register-confirm', $token) }}" method="post">
                @csrf
                <section class="login-input-text mx-2 mb-4" id="inputLoginSection">
                    <input class="border rounded text-right px-2" type="text" name="otp" value="{{ old('otp') }}"
                        required placeholder="کد تایید..." oninvalid="this.setCustomValidity('کد تایید را وارد کنید')"
                        oninput="this.setCustomValidity('')">
                    @error('otp')
                        <span class="alert_required text-danger p-1 rounded " role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2 text-center"><button
                        class="btn btn-primary py-2 px-3 w-75">تایید</button>
                </section>
            </form>
            <section id="resend-otp" class="d-none col-6 mx-auto">
                <a href="{{ route('auth.user.login-register-resend-otp' , $token) }}" class="text-decoration-none text-primary">دریافت مجدد کد تایید</a>
            </section>
            <section id="timer" class="col-9 mx-auto"></section>
        </section>
    </section>
@endsection


@section('script')
    @php
    $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(2)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;
    @endphp

    <script>
        var countDownDate = new Date().getTime() + {{ $timer }};
        var timer = $('#timer');
        var resendOtp = $('#resend-otp');

        var x = setInterval(function() {

            var now = new Date().getTime();

            var distance = countDownDate - now;

            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (minutes == 0) {
                timer.html('ارسال مجدد کد تایید بعد از ' + seconds + ' ثانیه')
            } else {
                timer.html('ارسال مجدد کد تایید بعد از ' + minutes + ' دقیقه و ' + seconds + ' ثانیه ');
            }
            if (distance < 0) {
                clearInterval(x);
                timer.addClass('d-none');
                resendOtp.removeClass('d-none');
            }

        }, 1000)
    </script>
@endsection
