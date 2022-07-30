@extends('admin.layouts.master')

@section('title')
    ویرایش نقش کاربر
@endsection


@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15"> کاربران </li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.manager.index') }}">
                    مدیران </a></li>
            <li class="breadcrumb-item font-size-15">ویرایش نقش کاربر</li>
        </ol>
    </nav>
    <section class="row ">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h4>
                        ویرایش نقش های {{ $admin->fullName }}
                    </h4>
                    <section class="d-flex justify-content-between align-items-center my-4">
                        <a href="{{ route('admin.manager.index') }}"
                            class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                    </section>
                    <section class="border-top pt-5">
                        <form action="{{ route('admin.manager.updateRole', $admin->id) }}" method="post">
                            @csrf
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label class="blue"  for="role_id">نقش</label>
                                    <select name="role_id" id="role_id" class="form-control form-control-sm">
                                        <option value="">بدون نقش</option>
                                        @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if(old('role_id' , $admin->role_id) == $role->id) selected @endif>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role_id')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-5">
                                <button class="btn btn-md text-white blue-color btn-hover mt-3">ثبت</button>
                            </section>
                        </form>
                    </section>
                </section>
            </section>
        </section>
    </section>
@endsection
