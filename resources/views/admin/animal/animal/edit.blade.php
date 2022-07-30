@extends('admin.layouts.master')

@section('title')
    ویرایش حیوان
@endsection

@section('head-tag')
    <link rel="stylesheet" href="{{ asset('general-assets/jalalidatepicker/persian-datepicker.min.css') }} ">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page">ویرایش حیوان</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش {{ $animal->name }}
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.animal.index') }}"
                        class="btn btn-sm text-white blue-color btn-hover">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.animal.update', $animal->id) }}" method="post" id="form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <section class="row">
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="name" class="blue">نام حیوان</label>
                                    <input type="text" name="name" value="{{ old('name', $animal->name) }}"
                                        class="form-control form-control-sm border-blue">
                                </div>
                                @error('name')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="english_name" class="blue">نام انگلیسی</label>
                                    <input type="text" name="english_name"
                                        value="{{ old('english_name', $animal->english_name) }}"
                                        class="form-control form-control-sm border-blue">
                                </div>
                                @error('english_name')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="scntf_name" class="blue">نام علمی</label>
                                    <input type="text" name="scntf_name"
                                        value="{{ old('scntf_name', $animal->scntf_name) }}"
                                        class="form-control form-control-sm border-blue">
                                </div>
                                @error('scntf_name')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <div class="col-12 col-md-6 py-2">
                                <div class="row">
                                    <section class="col-6">
                                        <div class="form-group">
                                            <label for="image" class="blue">تصویر </label>
                                            <input type="file" class="form-control form-control-sm border-blue" id="image"
                                                name="image" value="">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>
                                    <section class="col-6">
                                        <label for="currentImage" class="blue">اندازه تصویر </label>
                                        <select name="currentImage" class="form-control form-control-sm border-blue"
                                            id="currentImage">
                                            <option value="">اندازه تصویر را انتخاب نمایید</option>
                                            @php $val=array('small'=>'کوچک' , 'medium' =>'متوسط' , 'large' => 'بزرگ') @endphp
                                            @foreach ($val as $key => $value)
                                                <option value="{{ $key }}"
                                                    @if (old('currentImage', $animal->image['currentImage']) == $key) selected @endif> {{ $val[$key] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </section>
                                </div>
                            </div>
                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label for="summary" class="blue"> معرفی</label>
                                    <textarea type="text" name="summary" id="summary" class="form-control form-control-sm border-blue" value="">{{ old('summary', $animal->summary) }} </textarea>
                                </div>
                                @error('summary')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label for="threatening_factors" class="blue">عوامل تهدید کننده</label>
                                    <textarea type="text" name="threatening_factors" id="threatening_factors"
                                        class="form-control form-control-sm border-blue" value="">{{ old('threatening_factors', $animal->threatening_factors) }} </textarea>
                                </div>
                                @error('threatening_factors')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label for="habitat" class="blue">زیستگاه</label>
                                    <textarea type="text" name="habitat" id="habitat" class="form-control form-control-sm border-blue" value="">{{ old('habitat', $animal->habitat) }} </textarea>
                                </div>
                                @error('habitat')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="category_id" class="blue">دسته بندی</label>
                                    <select name="category_id" id="" class="form-control form-control-sm border-blue">
                                        <option value="">دسته را انتخاب کنید</option>
                                        @foreach ($animalCategories as $animalCategory)
                                            <option value="{{ $animalCategory->id }}"
                                                @if (old('category_id', $animal->category_id) == $animalCategory->id) selected @endif>
                                                {{ $animalCategory->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="protective_id" class="blue">وضعیت حفاظتی</label>
                                    <select name="protective_id" id="" class="form-control form-control-sm border-blue">
                                        <option value="">وضعیت حفاظتی را انتخاب کنید</option>
                                        @foreach ($protectives as $protective)
                                            <option value="{{ $protective->id }}"
                                                @if (old('protective_id', $animal->protective_id) == $protective->id) selected @endif>
                                                {{ $protective->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('protective_id')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="height" class="blue">قد (سانتیمتر)</label>
                                    <input type="text" name="height" value="{{ old('height', $animal->height) }}"
                                        class="form-control form-control-sm border-blue">
                                </div>
                                @error('height')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="weight" class="blue">وزن (کیلوگرم)</label>
                                    <input type="text" name="weight" value="{{ old('weight', $animal->weight) }}"
                                        class="form-control form-control-sm border-blue">
                                </div>
                                @error('weight')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label for="tags" class="blue">تگ ها</label>
                                    <input type="hidden" class="form-control form-control-sm border-blue" name="tags"
                                        id="tags" value="{{ old('tags', $animal->tags) }}">
                                    <select class="select2 form-control form-control-sm col-12 border-blue" id="select_tags"
                                        multiple>
                                    </select>
                                </div>
                                @error('tags')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="published_at" class="blue">تاریخ انتشار</label>
                                    <input type="text" name="published_at" id="published_at"
                                        class="form-control form-control-sm d-none" value="{{ old('published_at') }}">
                                    <input type="text" id="published_at_view"
                                        class="form-control form-control-sm  border-blue"
                                        value="{{ old('published_at', $animal->published_at) }}">
                                </div>
                                @error('published_at')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label for="status" class="blue">وضعیت</label>
                                    <select name="status" id="" class="form-control form-control-sm border-blue"
                                        id="status">
                                        <option value="0" @if (old('status', $animal->getRawOriginal('status')) == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if (old('status', $animal->getRawOriginal('status')) == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label for="description" class="blue">توضیحات</label>
                                    <textarea name="description" id="description" class="form-control form-control-sm">{{ old('description', $animal->description) }} </textarea>
                                </div>
                                @error('description')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <button class="btn blue-color btn-md text-white btn-hover mr-3">ثبت</button>
                            </section>
                        </section>
                    </form>
                </section>
                <hr>
                <section class="main-body-container-header">
                    <h5>
                        ویژگی های {{ $animal->name }}
                    </h5>
                </section>
                <section class="col-12 py-1 mb-1" id="metaDiv">
                    @foreach ($animal->metas as $meta)
                        <section class="row">
                            <section class="col-5">
                                <div class="form-group mb-1">
                                    <input type="text" name="meta_key[]" class="form-control form-control-sm"
                                        value="{{ $meta->meta_key }}">
                                </div>
                            </section>
                            <section class="col-5">
                                <div class="form-group">
                                    <input type="text" name="meta_value[]" class="form-control form-control-sm"
                                        value="{{ $meta->meta_value }}">
                                </div>
                            </section>
                            <form action="{{ route('admin.animal.meta.destroy', $meta->id) }}" method="post"
                                class="d-inline" id="deleteForm">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-lg btn-hover p-0 delete text-danger"
                                    title="حذف ویژگی"><i class="fa fa-times-rectangle-o"></i></button>
                            </form>
                            <span class="btn btn-lg btn-hover p-0 text-primary mx-2"
                                onclick="setMetaVal('{{ $meta->meta_key }}' , '{{ $meta->meta_value }}' , '{{ $meta->id }}')"
                                data-url="{{ route('admin.animal.meta.update', $meta->id) }}" id="editMetaButton"
                                title="ویرایش ویژگی" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i
                                    class="fa fa-edit"></i></span>
                        </section>
                    @endforeach
                </section>
                <form action="{{ route('admin.animal.meta.store', $animal->id) }}" method="post" id="addMetaForm">
                    @csrf
                    @method('post')
                    <section class="col-12 mb-1 d-none" id="addmetaSection">
                        <section class="row">
                            <section class="col-5">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="ویژگی ..."
                                        id="meta_key[]" name="meta_key[]" value="{{ old('meta_key') }}">
                                </div>
                                @error('meta_key.*')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-5">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="مقدار ..."
                                        id="meta_value[]" name="meta_value[]" value="{{ old('meta_value') }}">
                                </div>
                                @error('meta_value.*')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                        </section>
                    </section>
                    <section class="">
                        <button type="button" class="btn light-blue btn-sm btn-hover" id="addmetaButton">افزودن
                            ویژگی</button>
                    </section>
                </form>
                <br>

                <br>
                <section class="col-12 mt-3 d-none" id="submitmetaEditFormButton">
                    <button class="btn blue-color btn-md text-white btn-hover" onclick="submitmetaEditForm()"
                        title="ثبت ویژکی های جدید">ثبت</button>
                </section>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title blue" id="exampleModalLabel">ویرایش ویژگی</h5>
                            </div>
                            <div class="modal-body">
                                <section class="col-12 py-3 mb-3 mx-0 px-0">
                                    <section class="row">
                                        <section class="col-6">
                                            <div class="form-group mb-1">
                                                <input type="hidden" value="" id="metaId">
                                                <label for="meta_key[]" class="blue">ویژگی</label>
                                                <input type="text" name="meta_key[]" id="meta_key"
                                                    class="form-control form-control-sm border-blue" value="">
                                            </div>
                                        </section>
                                        <section class="col-6">
                                            <div class="form-group">
                                                <label for="meta_value[]" class="blue">مقدار</label>
                                                <input type="text" name="meta_value[]" id="meta_value"
                                                    class="form-control form-control-sm border-blue" value="">
                                            </div>
                                        </section>
                                    </section>
                                </section>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                                <button type="button" class="btn blue-color text-white btn-hover" id=""
                                    onclick="submitForm($('#meta_key').val(),$('#meta_value').val(),$('#metaId').val())">ثبت</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection

@section('script')
    <script src="{{ asset('general-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('general-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('general-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

    <script>
        function submitmetaEditForm() {
            $('#addMetaForm').submit();
        }
        $("#addmetaButton").click(function() {
            if ($('#addmetaSection').hasClass('d-none')) {
                $('#addmetaSection').removeClass('d-none');
                if ($('#submitmetaEditFormButton').hasClass('d-none')) {
                    $('#submitmetaEditFormButton').removeClass('d-none');
                }
                $(this).before($('#addmetaSection'));
            } else {
                var ele = $('#addmetaSection').clone(true);
                $(this).before(ele);
            }
        })
    </script>

    <script>
        function setMetaVal(key, value, id) {
            $('#meta_key').val(key);
            $('#meta_value').val(value);
            $('#metaId').val(id);
        }
    </script>

    <script>
        function submitForm(k, v, i) {
            let key = k;
            let value = v;
            let id = i;
            let url = "{{ route('admin.animal.meta.update', 'id') }}";
            url = url.replace('id', id);
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    meta_key: key,
                    meta_value: value,
                },
                success: function(response) {
                    $('#exampleModal').modal('hide');
                    $("#metaDiv").load(" #metaDiv > *");
                    successToast('ویژگی ویرایش شد');
                },
                error: function(response) {
                    $('#exampleModal').modal('hide');
                    errorToast('ویرایش انجام نشد');
                },
            });
        }
    </script>

    <script>
        $("#addmetaButton").click(function() {
            var ele = $(this).parent().prev().clone(true);
            $(this).before(ele);
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at',
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            var tags_input = $('#tags');
            var select_tags = $('#select_tags');
            var default_tags = tags_input.val();
            var default_data = null;
            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
            }
            select_tags.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data
            });
            select_tags.children('option').attr('selected', true).trigger('change');
            $('#form').submit(function(event) {
                if (select_tags.val() !== null && select_tags.val().length > 0) {
                    var selectedSource = select_tags.val().join(',');
                    tags_input.val(selectedSource)
                }
            })
        })
    </script>
    @include('alerts.sweetalerts.confirm', [
        'className' => 'delete',
        'message' => 'ویژگی حذف شود؟',
    ])
@endsection
