@extends('admin.layouts.master')

@section('title')
مدیران
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> کاربران </li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.manager.index') }}"> مدیران </a></li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    مدیران
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{route('admin.manager.create')}}" class="btn btn-sm text-white blue-color btn-hover">مدیر جدید</a>
                </section>
            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th>#</th>
                            <th>نام</th>
                            <th>ایمیل</th>
                            <th>شماره موبایل</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th class=" text-left"></i> تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Admins as $admin)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{$admin->fullName}} </td>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->mobile}} </td>
                            <td>
                                @if($admin->role == null)
                                <i class="fa fa-times text-danger mr-1"></i> ندارد
                                @else
                                <i class="fa fa-check text-primary mr-1"></i> {{$admin->role->name}}
                                @endif
                            </td>
                            <td class=""><label class="pointer">
                                    <input class="pointer" type="checkbox" id="{{ $admin->id }}" onchange="changeStatus( '{{ $admin->id }}' )" data-url="{{ route('admin.manager.status', $admin->id) }}" @if($admin->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.manager.destroy',  $admin->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.manager.edit', $admin->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i class="fa fa-edit blue"></i></a>
                                <a href="{{ route('admin.manager.editRole',  $admin->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش نقش"><i class="fas fa-user-shield text-primary"></i></a>
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
                        successToast('مدیر فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('مدیر غیرفعال شد')
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
@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'مدیر حذف شود؟'])
@endsection
