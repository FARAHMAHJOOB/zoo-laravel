@extends('admin.layouts.master')

@section('title')
سوالات متدوال
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"><a href="{{route('admin.home')}}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{route('admin.faq.index')}}">سوالات متداول</a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page">نمایش سوال</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header mb-4">
                <h5>
                    نمایش سوال
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <a href="{{ route('admin.faq.index') }}" class="btn btn-sm text-white blue-color btn-hover">بازگشت</a>
            </section>
            <section class="card mb-1">
                <section class="card-header text-dark light-blue font-weight-bold">
                    {{$faq->question}}
                </section>
                <section class="card-body py-0">
                    <p class="card-text">{!! $faq->answer!!}</p>
                    <p class="mb-1">{{jalaliDate($faq->created_at)}} </p>
                </section>
            </section>
        </section>
    </section>
</section>
@endsection
