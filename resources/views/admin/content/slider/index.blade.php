@extends('admin.layouts.master')

@section('title')
اسلایدر
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.content.slider.index') }}"> اسلایدر </a></li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                اسلایدر
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.slider.create') }}" class="btn btn-sm text-white blue-color btn-hover">اسلاید جدید</a>
                </section>
            </section>
            <div class="table-responsive border">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th class="">#</th>
                            <th class="">متن عکس</th>
                            <th class="">عکس</th>
                            <th class="">url</th>
                            <th class="">وضعیت</th>
                            <th class="text-left">تنظیمات </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                        <tr>
                            <td class="">{{$loop->iteration}}</td>
                            <th class="">{{ $slider->alt??'-' }}</th>
                            @if($slider->image)
                            <td class="py-1"><a href="{{url($slider->image) }}" target="_blank" title="مشاهده "><img src="{{asset($slider->image ) }}" alt="" width="50px" height="40px"></a></td>
                            @else
                            <td class="">-</td>
                            @endif
                            <td class="">{{ $slider->url }}</td>
                            <td class=""><label class="pointer">
                                    <input class="pointer" type="checkbox" id="{{ $slider->id }}" onchange="changeStatus( '{{ $slider->id }}' )" data-url="{{ route('admin.content.slider.status', $slider->id) }}" @if($slider->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.content.slider.destroy',  $slider->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.content.slider.edit', $slider->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i class="fa fa-edit blue"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </section>

    </section>
</section>
@endsection

@section('script')
<script type="text/javascript">
    function changeStatus(id) {
        var element = $("#" + id)
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.status) {
                    if (response.checked) {
                        element.prop('checked', true);
                        successToast('اسلاید فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('اسلاید غیرفعال شد')
                    }
                } else {
                    element.prop('checked', elementValue);
                    errorToast('در تغییر وضعیت مشکلی به جود آمد')
                }
            },
            error: function() {
                element.prop('checked', elementValue);
                errorToast('ارتباط برقرار نشد')
            }
        });
    }
</script>
@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'اسلایدر حذف شود؟'])

@endsection
