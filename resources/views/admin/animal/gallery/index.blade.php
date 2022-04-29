@extends('admin.layouts.master')

@section('title')
گالری حیوان
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> گالری</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    گالری
                    {{$animal->name}}

                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <div>
                    <a href="" class="btn btn-sm text-white blue-color" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">تصویر جدید </a>
                    <a href="{{ route('admin.animal.index') }}" class="btn btn-sm text-white blue-color">برگشت</a>
                </div>
                <!-- <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div> -->
            </section>

            <section id="galleryDiv">
                <div class="row px-1">
                    @foreach($animalImages as $animalImage)
                    <div class="col-md-2 px-1">
                        <div class="gallery w-100 p-1 rounded">
                            <a target="_blank" href="{{asset($animalImage->animal_image) }}">
                                <img src="{{asset($animalImage->animal_image) }}" alt="" style="height: 200px;" class="rounded-top">
                            </a>
                            <div class="desc d-flex light-blue pb-0 pt-2 pr-5 rounded-bottom">
                                <span id="{{ $animalImage->id }}" onclick="changeStatus( '{{ $animalImage->id }}' )" data-url="{{ route('admin.animal.image.status', $animalImage->id) }}" @if($animalImage->status === 1)
                                    <button class="btn btn-lg btn-hover p-0 mx-3 blue" title="غیرفعال کردن"> <i class="fa fa-check-square-o"></i></button>
                                    @else
                                    <button class="btn btn-lg btn-hover p-0 mx-3 blue" title="فعال کردن"> <i class="fa fa-square-o"></i></button>
                                    @endif
                                </span>
                                <form action="{{ route('admin.animal.image.destroy',  $animalImage->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg btn-hover p-0 delete mx-3 mb-0" title="حذف" id="btnDelete"><i class='far fa-minus-square text-danger'></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title blue" id="exampleModalLabel">عکس جدید</h5>
                        </div>
                        <div class="modal-body">
                            <section class="col-12 py-3 mb-3">
                                <form action="{{ route('admin.animal.image.store' , $animal->id) }}" method="post" id="addanimalGalleryForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <input type="file" class="form-control form-control-sm" placeholder="تصویر ..." id="animal_image[]" name="animal_image[]">
                                    </div>
                                    @error('animal_image.*')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                    <section>
                                        <button type="button" class="btn light-blue text-dark btn-sm mt-2" id="addImageButton"> افزودن تصویر</button>
                                    </section>
                                </form>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                            <button type="button" class="btn blue-color text-white" id="addanimalGalleryFormButton">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </section>
</section>

@endsection


@section('script')
<script>
    $("#addImageButton").click(function() {
        var ele = $(this).parent().prev().clone();
        $(this).before(ele);
    })

    $("#addanimalGalleryFormButton").click(function() {
        $("#addanimalGalleryForm").submit();
    })
</script>

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
        // var elementValue = !element.prop('checked');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.status) {
                    $("#galleryDiv").load(" #galleryDiv > *");
                    if (response.checked) {
                        successToast('عکس فعال شد')
                    } else {
                        successToast('عکس غیر فعال شد')
                    }
                } else {
                    errorToast('در تغییر وضعیت مشکلی به جود آمد')
                }
            },
            error: function() {
                errorToast('ارتباط برقرار نشد')
            }
        });
    }
</script>
@include('admin.alerts.sweetalerts.confirm', ['className' => 'delete' , 'message' => 'عکس حذف شود؟'])

@endsection