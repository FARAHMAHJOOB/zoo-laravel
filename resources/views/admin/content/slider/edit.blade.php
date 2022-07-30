@extends('admin.layouts.master')

@section('title')
ویراش اسلاید
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.content.slider.index') }}"> اسلایدر </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> ویرایش اسلاید </li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                   ویرایش اسلاید
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.slider.index') }}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
            </section>
            <div>
                <form action="{{ route('admin.content.slider.update' , $slider->id) }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="alt">متن عکس</label>
                                <input type="text" class="form-control form-control-sm" id="alt" name="alt" value="{{ old('alt' , $slider->alt) }}">
                            </div>
                            @error('alt')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label for="image" class="blue">عکس</label>
                                <input type="file" class="form-control form-control-sm" id="image" name="image">
                            </div>
                            @error('image')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>

                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="url">آدرس url</label>
                                <input type="text" class="form-control form-control-sm" id="url" name="url" value="{{ old('url' , $slider->url) }}">
                            </div>
                            @error('url')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="status">وضعیت</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="0" @if(old('status' , $slider->status)==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status' , $slider->status)==1) selected @endif>فعال</option>
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
                        <section class="col-12 mt-3">
                            <button class="btn btn-md text-white blue-color btn-hover">ثبت</button>
                        </section>
                    </section>
                </form>
            </div>
        </section>

    </section>
</section>
@endsection
