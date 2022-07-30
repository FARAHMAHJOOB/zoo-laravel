@extends('admin.layouts.master')

@section('title')
منو
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.content.menu.index') }}"> منو </a></li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    منو
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.menu.create') }}" class="btn btn-sm text-white blue-color btn-hover">منوی جدید</a>
                </section>
            </section>
            <div class="table-responsive border">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th class="">#</th>
                            <th class=""> نام منو</th>
                            <th class="">منوی والد</th>
                            <!-- <th class="">منوی فرزند</th> -->
                            <th class="">url</th>
                            <th class="">وضعیت</th>
                            <th class="text-left">تنظیمات </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $number=>$menu)
                        <tr>
                            <td class="">{{$number+=1}}</td>
                            <th class="">{{ $menu->name }}</th>
                            <td class="">{{$menu->parent->name??'اصلی'}}</td>
                            <!-- <td class="">{{$menu->childs ? $menu->childs()->get():'no'}}</td> -->
                            <td class="">{{ $menu->url }}</td>
                            <td class=""><label class="pointer">
                                    <input class="pointer" type="checkbox" id="{{ $menu->id }}" onchange="changeStatus( '{{ $menu->id }}' )" data-url="{{ route('admin.content.menu.status', $menu->id) }}" @if($menu->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.content.menu.destroy',  $menu->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.content.menu.edit', $menu->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i class="fa fa-edit blue"></i></a>
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
                        successToast('منو فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('منو غیرفعال شد')
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
@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'منو حذف شود؟'])

@endsection
