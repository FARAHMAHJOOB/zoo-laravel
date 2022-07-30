@extends('auth.layouts.master')
@section('title')
   تغییر رمز عبور
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
                    <h4>تغییر کلمه عبور</h4>
                </div>
                <!-- Form -->
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-white">{{ __('ایمیل') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-white">{{ __('رمز عبور') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end text-white">{{ __('تکرار رمز عبور') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('تغییر کلمه عبور') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- FORM CONTAINER END -->
    </div>
@endsection
