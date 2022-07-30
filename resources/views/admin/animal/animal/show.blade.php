@extends('admin.layouts.master')

@section('title')
جزییات حیوان
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page">جزئیات حیوان</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    جزئیات {{$animal->name}}
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.animal.index')}}" class="btn btn-sm text-white blue-color">بازگشت</a>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px  mx-auto" id="printable">
                    <!-- <thead>
                        <tr>
                            <th>#</th>
                            <th class="max-width-16-rem text-left"> تنظیمات</th>
                        </tr>
                    </thead> -->
                    <tbody>
                        <tr>
                            <th class="light-blue">{{ $animal->id }}</th>
                            <td class="width-8-rem text-left light-blue">
                                <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                    <i class="fa fa-print"></i>
                                    چاپ
                                </a>
                                <a href="{{route('admin.animal.edit' , $animal->id)}}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-book"></i>
                                    ویرایش
                                </a>
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>نام </th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام انگلیسی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->english_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام علمی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->scntf_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>خلاصه</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->summary ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>دسته</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->category->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت حفاظتی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->protective->title ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>قد</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->height . ' ' .'سانتیمتر' ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وزن</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->weight . ' '. 'کیلوگرم' ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>عوامل تهدید کننده</th>
                            <td class="text-left font-weight-bolder">
                                {{$animal->threatening_factors ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>زیستگاه</th>
                            <td class="text-left font-weight-bolder">
                                {{$animal->habitat ?? '-'}}
                            </td>
                        </tr>
                        @foreach($animal->metas as $meta)
                        <tr class="border-bottom">
                            <th>{{$meta->meta_key}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $meta->meta_value}}
                            </td>
                        </tr>
                        @endforeach
                        <tr class="border-bottom">
                            <th>وضعیت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $animal->status?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تاریخ انتشار</th>
                            <td class="text-left font-weight-bolder">
                                {{jalaliDate($animal->published_at) ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>توضیحات</th>
                            <td class="text-left font-weight-bolder">
                                {!! $animal->description ?? '-' !!}
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