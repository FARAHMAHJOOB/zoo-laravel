@extends('admin.layouts.master')

@section('title')
ویرایش کاربر
@endsection
@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> کاربران </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.user.index') }}"> کاربران سایت </a></li>
        <li class="breadcrumb-item font-size-15"> ویرایش کاربر </li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    ویرایش کاربر
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{route('admin.user.index')}}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.user.update' , $user->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <section class="row">
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label class="blue"  for="">نام</label>
                                    <input type="text" class="form-control form-control-sm" name="first_name" value="{{ old('first_name' ,$user->first_name ) }}">
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
                                    <input type="text" class="form-control form-control-sm" name="last_name" value="{{ old('last_name',$user->last_name) }}">
                                </div>
                                @error('last_name')
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
                                    <input type="text" class="form-control form-control-sm" name="national_code" value="{{ old('national_code' , $user->national_code) }}">
                                </div>
                                @error('national_code')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group mb-1">
                                    <label class="blue"  for="status"> وضعیت فعال سازی</label>
                                    <select name="activation" class="form-control form-control-sm" id="activation">
                                        <option value="0" @if(old('activation',$user->activation)==0) selected @endif>غیرفعال</option>
                                        <option value="1" @if(old('activation',$user->activation)==1) selected @endif>فعال</option>
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
                            @if($user->profile_photo_path)
                            <section class="col-12 col-md-6 my-2">
                                <a href="{{ url($user->profile_photo_path) ?? $user->profile_photo_path }}" target="_blanket" > <img src="{{ asset($user->profile_photo_path)??$user->profile_photo_path }}" alt="" width="70" height="50" class="mt-3"></a>
                            </section>
                            @endif
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
