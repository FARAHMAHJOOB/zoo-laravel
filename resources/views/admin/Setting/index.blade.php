@extends('admin.layouts.master')

@section('title')
تنظیمات
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> تنظیمات</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header mb-4">
                <h5>
                    تنظیمات
                </h5>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th>#</th>
                            <th>عنوان سایت</th>
                            <th>توضیحات سایت</th>
                            <th>کلمات کلیدی سایت</th>
                            <th>لوگو سایت</th>
                            <th>آیکون سایت</th>
                            <th class="text-center"> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>{{ $setting->title }}</td>
                            <td>{{ $setting->description }}</td>
                            <td>{{ $setting->keywords }}</td>
                            <td><a href="{{ url($setting->logo) }}" target="_blanket" alt="logo"><img src="{{ asset($setting->logo) }}" alt="" width="50px" height="40px"></a></td>
                            <td><a href="{{ url($setting->icon) }}" target="_blanket" alt="icon"><img src="{{ asset($setting->icon) }}" alt="" width="50px" height="40px"></a></td>
                            <td class=" text-center">
                            <a href="{{ route('admin.setting.edit',  $setting->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش"><i class="fa fa-edit blue"></i> </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection
