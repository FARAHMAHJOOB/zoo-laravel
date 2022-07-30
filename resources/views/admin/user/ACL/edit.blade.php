@extends('admin.layouts.master')

@section('title')
ویرایش نقش
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> کاربران </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.role.index') }}"> سطوح دسترسی </a></li>
        <li class="breadcrumb-item font-size-15"> ویرایش نقش</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    ویرایش نقش
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                <div>
                    <input type="checkbox" class="form-check-input d-none" id="checkAll">
                    <label for="checkAll" class="mx-4 btn btn-info btn-sm"> انتخاب/عدم انتخاب همه دسترسی ها </label>
                </div>
            </section>

            <section>
                <form action="{{ route('admin.role.update', $role->id) }}" method="post">
                    @csrf
                    @method('put')
                    <section class="row">
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group mb-0">
                                <label for="">عنوان نقش</label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name' , $role->name) }}">
                            </div>
                            @error('name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group mb-0">
                                <label for="status">وضعیت</label>
                                <select name="status" class="form-control form-control-sm" id="status">
                                    <option value="0" @if(old('status' , $role->status)==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status' , $role->status)==1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group mb-0">
                                <label for="">توضیح نقش</label>
                                <input type="text" class="form-control form-control-sm" name="slug" value="{{ old('slug' , $role->slug) }}">
                            </div>
                            @error('slug')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <section class="row border-top mt-3 py-3">
                                @php
                                $rolePermissionsArray = $role->permissions->pluck('id')->toArray();
                                @endphp
                                @foreach($permissions as $permission)
                                <section class="col-md-2 my-1">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="permission[]" value="{{$permission->id}}" id="{{$permission->id}}" @if(in_array($permission->id,old('permission', $rolePermissionsArray))) checked @endif />
                                        <label for="{{$permission->id}}" class="form-check-label mr-3 mt-1">{{$permission->name}}</label>
                                    </div>
                                </section>
                                @endforeach
                            </section>
                            @error('permission')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-2">
                            <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                        </section>

                    </section>
                </form>
            </section>
        </section>
    </section>
</section>

@endsection

@section('script')
    <script>
        $("#checkAll").click(function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));

        });
    </script>
@endsection
