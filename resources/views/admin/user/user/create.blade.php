@extends('admin.layouts.master')

@section('title')
کاربر جدید
@endsection
@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> کاربران </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.user.index') }}"> کاربران سایت </a></li>
        <li class="breadcrumb-item font-size-15"> کاربر جدید </li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    کاربر جدید
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{route('admin.user.index')}}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
            <section>
                <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">نام</label>
                                <input type="text" class="form-control form-control-sm" name="first_name" value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">نام خانوادگی</label>
                                <input type="text" class="form-control form-control-sm" name="last_name" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">ایمیل</label>
                                <input type="text" class="form-control form-control-sm" name="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for=""> شماره موبایل</label>
                                <input type="text" class="form-control form-control-sm" name="mobile" value="{{ old('mobile') }}">
                            </div>
                            @error('mobile')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="national_code"> کد ملی</label>
                                <input type="text" class="form-control form-control-sm" name="national_code" value="{{ old('national_code') }}">
                            </div>
                            @error('national_code')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">کلمه عبور</label>
                                <input type="password" class="form-control form-control-sm" name="password" value="{{ old('password') }}">
                            </div>
                            @error('password')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">تکرار کلمه عبور</label>
                                <input type="password" class="form-control form-control-sm" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            </div>
                            @error('confirmPassword')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="">عکس</label>
                                <input type="file" class="form-control form-control-sm" name="profile_photo_path">
                            </div>
                            @error('profile_photo_path')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="status">فعال سازی</label>
                                <select name="activation" class="form-control form-control-sm" id="activation">
                                    <option value="0" @if(old('activation')==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('activation')==1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('activation')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <button class="btn btn-md text-white blue-color btn-hover mt-3">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
