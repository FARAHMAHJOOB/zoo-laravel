@extends('admin.layouts.master')

@section('title')
منوی جدید
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.content.menu.index') }}"> منو </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> منوی جدید</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    منوی جدید
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.menu.index') }}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
            </section>
            <div>
                <form action="{{ route('admin.content.menu.store') }}" method="post" id="form">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="name">نام منو</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="parent_id">منو والد</label>
                                <select class="form-control form-control-sm" id="parent_id" name="parent_id">
                                    <option value="">منوی اصلی</option>
                                    @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" @if(old('parent_id')==$menu->id) selected @endif>{{$menu->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
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
                                <input type="text" class="form-control form-control-sm" id="url" name="url" value="{{ old('url') }}">
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
                                    <option value="0" @if(old('status')==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status')==1) selected @endif>فعال</option>
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
