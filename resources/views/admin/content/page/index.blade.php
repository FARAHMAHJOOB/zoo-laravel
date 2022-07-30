@extends('admin.layouts.master')

@section('title')
پیج ساز
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.content.page.index') }}"> پیج ساز </a></li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    پیج ساز
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.page.create') }}" class="btn btn-sm text-white blue-color btn-hover">پیج جدید</a>
                </section>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th class="py-2">#</th>
                            <th class="py-2">عنوان صفحه</th>
                            <th class="py-2">متن </th>
                            <th class="py-2">تگ</th>
                            <th class="py-2">وضعیت</th>
                            <th class="text-left py-2">تنظیمات </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $number=>$page)
                        <tr>
                            <th class="">{{ $loop->iteration }}</th>
                            <td class="">{{ $page->title }}</td>
                            <td class="">{!! $page->body !!}</td>
                            <td class="">{{ $page->tags }}</td>
                            <td class=""><label class="pointer">
                                    <input class="pointer" type="checkbox" id="{{ $page->id }}" onchange="changeStatus( '{{ $page->id }}' )" data-url="{{ route('admin.content.page.status', $page->id) }}" @if($page->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.content.page.destroy',  $page->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.content.page.edit', $page->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i class="fa fa-edit blue"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                        successToast('صفحه فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('صفحه غیرفعال شد')
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
@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'صفحه حذف شود؟'])

@endsection
