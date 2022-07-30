@extends('admin.layouts.master')

@section('title')
ویرایش مدیر
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> کاربران </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.manager.index') }}"> مدیران </a></li>
        <li class="breadcrumb-item font-size-15">ویرایش مدیر</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                  ویرایش مدیر
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{route('admin.manager.index')}}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
            <section>
                <form action="{{route('admin.manager.update' , $admin->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="first_name">نام</label>
                                <input type="text" class="form-control form-control-sm" name="first_name" value="{{ old('first_name' ,$admin->first_name ) }}">
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
                                <label class="blue"  for="last_name">نام خانوادگی</label>
                                <input type="text" class="form-control form-control-sm" name="last_name" value="{{ old('last_name',$admin->last_name) }}">
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
                                <input type="text" class="form-control form-control-sm" name="national_code" value="{{ old('national_code' , $admin->national_code) }}">
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
                                    <option value="0" @if(old('activation',$admin->activation)==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('activation',$admin->activation)==1) selected @endif>فعال</option>
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
                                <label class="blue"  for="profile_photo_path">عکس</label>
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
                        @if($admin->profile_photo_path)
                        <section class="col-12 col-md-6 my-2">
                            <img src="{{ asset($admin->profile_photo_path) }}" alt="" width="70" height="50" class="mt-3">
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
