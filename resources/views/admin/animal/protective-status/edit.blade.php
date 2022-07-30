@extends('admin.layouts.master')

@section('title')
ویرایش وضعیت حفاظتی
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.protectiveStatus.index') }}"> وضعیت حفاظتی</a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> ویرایش وضعیت حفاظتی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    ویرایش وضعیت حفاظتی
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <div>
                    <a href="{{ route('admin.animal.protectiveStatus.index') }}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </div>
            </section>
            <section class="col-12 py-3 mb-3">
                <form action="{{ route('admin.animal.protectiveStatus.update' , $status->id) }}" method="post" id="addanimalProtectiveForm" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <label for="title" class="blue">عنوان</label>
                    <div class="form-group mb-1">
                        <input type="text" class="form-control form-control-sm border-blue" placeholder="عنوان وضعیت ..." id="title" name="title" value="{{old('title' , $status->title)}}" />
                    </div>
                    @error('title')
                    <span class="text-danger">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                    @enderror
                    <br>
                    <label for="description" class="mt-3 blue">توضیحات</label>
                    <div class="form-group mb-2">
                        <textarea class="form-control form-control-sm border-blue" placeholder="توضیحات ..." id="description" name="description" rows="3">{{old('description' , $status->description)}}</textarea>
                    </div>
                    @error('description')
                    <span class="text-danger">
                        <strong>
                            {{ $message }}
                        </strong>
                    </span>
                    @enderror
                    <br>
                    <button type="submit" class="btn blue-color text-white btn-hover mt-4" id="addanimalProtectiveFormButton">ثبت</button>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
