@extends('admin.layouts.master')

@section('title')
سوالات متداول
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{route('admin.home')}}">خانه </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> سوالات متداول</li>
    </ol>
</nav>

<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    سوالات متداول
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.faq.create') }}" class="btn blue-color text-white btn-hover btn-sm">سوال جدید</a>
                </section>
                <div class="table-responsive border">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="light-blue">
                                <th class="py-2">#</th>
                                <th class="py-2"> متن سوال</th>
                                <th class="py-2">پاسخ</th>
                                <th class="py-2">تگ</th>
                                <th class="py-2">وضعیت</th>
                                <th class="text-left py-2 pl-4">تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $number=>$faq)
                            <tr>
                                <th class="">{{ $number+=1 }}</th>
                                <td class="">{{ $faq->question }}</td>
                                <td class="">{!!Str::limit($faq->answer , 50)  !!}</td>
                                <td class="">{{ $faq->tags }}</td>
                                <td class=""><label class="pointer">
                                        <input class="pointer" type="checkbox" id="{{ $faq->id }}" onchange="changeStatus( '{{ $faq->id }}' )" data-url="{{ route('admin.faq.status', $faq->id) }}" @if($faq->status === 1)
                                        checked
                                        @endif>
                                    </label>
                                </td>
                                <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.faq.destroy',  $faq->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.faq.edit',  $faq->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش"><i class="fa fa-edit blue"></i> </a>
                                <a href="{{ route('admin.faq.show',  $faq->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="جزییات"><i class="fa fa-info-circle text-primary"></i></a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
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
                        successToast('سوال فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('سوال غیرفعال شد')
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
@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'سوال حذف شود؟'])
@endsection
