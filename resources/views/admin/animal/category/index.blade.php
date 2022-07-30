@extends('admin.layouts.master')

@section('title')
دسته بندی حیوانات
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> دسته بندی حیوانات</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    دسته بندی حیوانات
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <div>
                    <a href="{{route('admin.animal.category.create')}}" class="btn btn-sm text-white blue-color btn-hover">دسته بندی جدید </a>
                </div>
            </section>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="light-blue">
                            <th class="py-2">#</th>
                            <th class="py-2"> نام</th>
                            <th class="py-2">توضیحات</th>
                            <th class="py-2">دسته والد</th>
                            <th class="py-2">تگ ها</th>
                            <th class="py-2">عکس</th>
                            <th class="py-2">وضعیت </th>
                            <th class="text-left py-2 pl-4">تنظیمات </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($animalCategories as $category)
                        <tr>
                            <td class="">{{$loop->iteration}}</td>
                            <th class="">{{$category->name}}</th>
                            <td class="" title="{{$category->description}}">{!! Str::limit($category->description , 50 )!!}</td>
                            <td class="">{{$category->parent->name?? '--'}}</td>
                            <td class="">{{$category->tags??'--'}}</td>
                            @if($category->image)
                            <td class="py-1"><a href="{{url($category->image) }}" target="_blank" title="مشاهده "><img src="{{asset($category->image ) }}" alt="" width="50px" height="40px"></a></td>
                            @else
                            <td class="">-</td>
                            @endif
                            <td>
                                <label class="pointer">
                                    <input class="pointer" id="{{ $category->id }}" onchange="changeStatus('{{ $category->id }}')" data-url="{{ route('admin.animal.category.status', $category->id) }}" type="checkbox" @if ($category->getRawOriginal('status') === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="text-left d-flex ltr pt-2 pl-0">
                                <form action="{{ route('admin.animal.category.destroy',  $category->id) }}" method="POST" title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.animal.category.edit',  $category->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش"><i class="fa fa-edit blue"></i> </a>
                                <a href="{{ route('admin.animal.category.show',  $category->id) }}" class="btn btn-lg py-0 px-2 btn-hover" title="جزییات"><i class="fa fa-info-circle text-primary"></i></a>
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
                        successToast('رکورد فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('رکورد غیرفعال شد')
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

@include('alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'دسته بندی حذف شود؟'])
@endsection
