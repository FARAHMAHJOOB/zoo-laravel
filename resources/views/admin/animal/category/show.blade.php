@extends('admin.layouts.master')

@section('title')
جزییات دسته بندی
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.category.index') }}"> دسته بندی حیوانات</a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> جزییات دسته بندی </li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    جزئیات {{$category->name}}
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <a href="{{ route('admin.animal.category.index')}}" class="btn btn-sm text-white blue-color btn-hover">بازگشت</a>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px mx-auto" id="printable">
                    <!-- <thead>
                        <tr>
                            <th>#</th>
                            <th class="max-width-16-rem text-left"> تنظیمات</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <th class="light-blue">{{ $category->id }}</th>
                            <td class="width-8-rem text-left light-blue">
                                <a href="{{route('admin.animal.category.edit' , $category->id)}}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-book"></i>
                                    ویرایش
                                </a>
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>نام </th>
                            <td class="text-left font-weight-bolder">
                                {{$category->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>دسته والد</th>
                            <td class="text-left font-weight-bolder">
                                {{ $category->parent->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تگ ها</th>
                            <td class="text-left font-weight-bolder">
                                {{ $category->tags ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $category->status?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>توضیحات</th>
                            <td class="text-left font-weight-bolder">
                                {!! $category->description ?? '-' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>
@endsection

@section('script')
<script>
    var printBtn = document.getElementById('print');
    printBtn.addEventListener('click', function() {
        printContent('printable');
    })

    function printContent(el) {
        var restorePage = $('body').html();
        var printContent = $('#' + el).clone();
        $('body').empty().html(printContent);
        window.print();
        $('body').html(restorePage);
    }
</script>
@endsection
