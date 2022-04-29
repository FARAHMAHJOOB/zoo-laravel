@extends('admin.layouts.master')

@section('title')
حیوانات
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    حیوانات
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{route('admin.animal.create')}}" class="btn btn-sm text-white blue-color">حیوان جدید</a>
                       @livewire('admin.animal.animal-search')
                </section>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="light-blue">
                                <th class="py-2">#</th>
                                <th class="py-2"> نام</th>
                                <th class="py-2">خلاصه</th>
                                <th class="py-2">دسته</th>
                                <th class="py-2">تاریخ انتشار</th>
                                <th class="py-2">عکس</th>
                                <th class="py-2">وضعیت </th>
                                <th class="text-center py-2">تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($animals as $animal)
                            <tr>
                                <td class="">{{$loop->iteration}}</td>
                                <th class="">{{$animal->name}}</th>
                                <td class="" title="{{$animal->summary}}">{{Str::limit($animal->summary , 20)}}</td>
                                <td class="">{{$animal->category->name}}</td>
                                <td class="">{{jalaliDate($animal->published_at)}}</td>
                                @if($animal->image)
                                <td class="py-1"><a href="{{url($animal->image['indexArray'][$animal->image['currentImage']] ) }}" target="_blank" title="مشاهده "><img src="{{asset($animal->image['indexArray'][$animal->image['currentImage']] ) }}" alt="" width="50px" height="40px"></a></td>
                                @else
                                <td class="">----</td>
                                @endif
                                <td>
                                    <label>
                                        <input class="" id="{{ $animal->id }}" onchange="changeStatus('{{ $animal->id }}')" data-url="{{ route('admin.animal.status', $animal->id) }}" type="checkbox" @if ($animal->getRawOriginal('status') === 1)
                                        checked
                                        @endif>
                                    </label>
                                </td>
                                <td class="text-left w-150px d-flex py-0 pt-1">
                                    <a href="{{ route('admin.animal.show',  $animal->id) }}" class="btn btn-lg py-0 btn-hover" title="جزییات"><i class="fa fa-info-circle text-primary"></i></a>
                                    <div class="dropdown ml-0 ">
                                        <a href="#" title="عملیات" class="btn btn-lg py-0 px-1 btn-hover text-success dorpdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-tools"></i>
                                        </a>
                                        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                                            <a href="{{ route('admin.animal.gallery.index' , $animal->id) }}" class="dropdown-item text-right text-primary border-bottom"><i class="fa fa-picture-o"></i> گالری</a>
                                            <a href="{{ route('admin.animal.edit',  $animal->id) }}" class="dropdown-item text-right text-warning border-bottom"><i class="fa fa-edit"></i> ویرایش</a>
                                            <form action="{{ route('admin.animal.destroy',  $animal->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="dropdown-item text-right text-danger border-bottom delete"><i class="fa fa-window-close"></i> حذف</button>
                                            </form>
                                        </div>
                                    </div>
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

<!-- 
<script type="text/javascript">
    $('#search').on('keyup', function() {
        $value = $(this).val();
        $.ajax({
            type: 'get',
            url: '{{route("admin.animal.search")}}',
            "_token": "{{ csrf_token() }}",
            data: {
                'search': $value
            },
            success: function(data) {
                $('#tbody').html(data);
            }
        });
    })
</script> -->
<script type="text/javascript">
    function successToast(message) {
        var successToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex light-blue text-dark">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(successToastTag);
        $('.toast').toast('show').delay(5000).queue(function() {
            $(this).remove();
        })
    }

    function errorToast(message) {

        var errorToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(errorToastTag);
        $('.toast').toast('show').delay(5500).queue(function() {
            $(this).remove();
        })
    }

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
                        successToast('رکورد غیر فعال شد')
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
@include('admin.alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'رکورد حذف شود؟'])

@endsection