
@extends('auth.layouts.master')
@section('title')
    ورود به حساب کاربری
@endsection

@section('content')
    <div class="row flex-row-reverse">
        <!-- IMAGE CONTAINER BEGIN -->
        <div class="d-none col-lg-6 col-md-6 d-md-block infinity-image-container"></div>
        <!-- IMAGE CONTAINER END -->

        <!-- FORM CONTAINER BEGIN -->
        <div class="col-12 col-lg-6 col-md-6 infinity-form-container">
            <div class="col-lg-9 col-md-12 col-sm-9 col-xs-12 infinity-form">
                <div class="mb-5">
                    <a href="{{route('home')}}" class="btn px-3 btn-primary">صفحه اصلی</a>
                </div>
                <!-- Company Logo -->
                <div class="text-center mt-5">
                    <img src="{{ asset('images/logo.png') }}" width="150px">
                </div>
                <div class="text-center mt-4 mb-5">
                    <h4>ورود به حساب کاربری</h4>
                </div>
                <!-- Form -->
                <form class="px-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Input Box -->
                    <div class="form-input d-flex flex-row-reverse">
                        <span><i class="fa fa-envelope-o"></i></span>
                        <input type="email" name="email" placeholder="ایمیل" tabindex="10" required
                            class="pr-3 @error('email') is-invalid @enderror">
                    </div>
                    <div class="form-input d-flex flex-row-reverse">
                        <span><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" placeholder="رمز عبور" required
                            class="pr-3  @error('password') is-invalid @enderror" id="password">
                    </div>
                    <div class="mb-3">
                        @error('email')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        @error('password')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-3 justify-content-between">
                        <!-- Remember Checkbox -->
                        {{-- <div class="col-auto d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label text-white" for="remember">مرا به خاطر بسپار</label>
                            </div>
                        </div> --}}
                        <!-- ShowPassword Checkbox -->
                        <div class="col-auto d-flex align-items-center">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" onclick="myFunction()" class="custom-control-input"
                                    name="showPassword" id="showPassword">
                                <label class="custom-control-label text-white" for="showPassword">نمایش رمز عبور</label>
                            </div>
                        </div>
                    </div>
                    <!-- Login Button -->
                    <div class="mb-5 mt-3">
                        <button type="submit" class="btn btn-block">ورود</button>
                    </div>
                    <div class="text-right ">
                        <a href="{{ route('password.request') }}" class="forget-link">رمز عبور خود را فراموش کرده
                            اید؟</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- FORM CONTAINER END -->
    </div>
@endsection
@section('script')
    <script>
        function myFunction() {
            var x = document.getElementById('password');
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
