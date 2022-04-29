@extends('admin.layouts.master')

@section('title')
حیوان جدید
@endsection

@section('head-tag')
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }} ">
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page">حیوان جدید</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    حیوان جدید
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.animal.index') }}" class="btn btn-sm text-white blue-color">بازگشت</a>
            </section>
            <section>
                <form action="{{ route('admin.animal.store') }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label for="name" class="blue">نام حیوان</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-sm border-blue">
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
                                <input type="text" name="english_name" value="{{ old('english_name') }}" class="form-control form-control-sm border-blue">
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
                                <input type="text" name="scntf_name" value="{{ old('scntf_name') }}" class="form-control form-control-sm border-blue">
                            </div>
                            @error('scntf_name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <section class="col-6">
                                    <div class="form-group">
                                        <label for="image" class="blue">تصویر </label>
                                        <input type="file" class="form-control form-control-sm border-blue" id="image" name="image" value="">
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
                                    <select name="currentImage" class="form-control form-control-sm border-blue" id="currentImage">
                                        <option value="">اندازه تصویر را انتخاب نمایید</option>
                                        @php $val=array('small'=>'کوچک' , 'medium' =>'متوسط' , 'large' => 'بزرگ') @endphp
                                        @foreach($val as $key=>$value)
                                        <option value="{{ $key }}" @if(old('currentImage')==$key) selected @endif> {{ $val[$key] }}</option>
                                        @endforeach
                                    </select>
                                </section>
                            </div>
                        </div>
                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label for="summary" class="blue"> معرفی</label>
                                <textarea type="text" name="summary" id="summary" class="form-control form-control-sm border-blue" value="">{{ old('summary') }} </textarea>
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
                                <textarea type="text" name="threatening_factors" id="threatening_factors" class="form-control form-control-sm border-blue" value="">{{ old('threatening_factors') }} </textarea>
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
                                <textarea type="text" name="habitat" id="habitat" class="form-control form-control-sm border-blue" value="">{{ old('habitat') }} </textarea>
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
                                    <option value="{{ $animalCategory->id }}" @if(old('category_id')==$animalCategory->id) selected @endif>{{ $animalCategory->name }}</option>
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
                                    <option value="{{ $protective->id }}" @if(old('protective_id')==$protective->id) selected @endif>{{ $protective->title }}</option>
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
                                <input type="text" name="height" value="{{ old('height') }}" class="form-control form-control-sm border-blue">
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
                                <input type="text" name="weight" value="{{ old('weight') }}" class="form-control form-control-sm border-blue">
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
                                <input type="hidden" class="form-control form-control-sm border-blue" name="tags" id="tags" value="{{ old('tags') }}">
                                <select class="select2 form-control form-control-sm col-12 border-blue" id="select_tags" multiple>
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
                                <input type="text" name="published_at" id="published_at" class="form-control form-control-sm d-none" value="{{ old('published_at') }}">
                                <input type="text" id="published_at_view" class="form-control form-control-sm  border-blue" value="{{ old('published_at') }}">
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
                                <select name="status" id="" class="form-control form-control-sm border-blue" id="status">
                                    <option value="0" @if(old('status')==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
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
                                <textarea name="description" id="description" class="form-control form-control-sm">{{ old('description') }} </textarea>
                            </div>
                            @error('description')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 py-3 mb-3">
                            <section class="row">
                                <section class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="ویژگی ..." id="meta_key[]" name="meta_key[]" value="{{ old('meta_key.0') }}">
                                    </div>
                                </section>
                                <section class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" placeholder="مقدار ..." id="meta_value[]" name="meta_value[]" value="{{ old('meta_value.0') }}">
                                    </div>
                                </section>
                            </section>
                            <section>
                                <button type="button" class="btn light-blue btn-sm" id="addAttributeButton">افزودن ویژگی</button>
                            </section>
                        </section>
                        <section class="col-2 ml-0 pl-0">
                            <button class="btn btn-md text-white blue-color">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection

@section('script')
<script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
<script>
    CKEDITOR.replace('description');
</script>


<script>
    $("#addAttributeButton").click(function() {
        var ele = $(this).parent().prev().clone(true);
        $(this).before(ele);
    })

    $("#addColorButton").click(function() {
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
@endsection