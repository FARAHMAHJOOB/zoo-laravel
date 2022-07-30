@extends('admin.layouts.master')

@section('title')
تنظیمات
@endsection

@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> تنظیمات</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تنظیمات</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    ویرایش تنظیمات</>
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-5 pb-2">
                <a href="{{ route('admin.setting.index') }}" class="btn btn-sm blue-color btn-hover text-white">بازگشت</a>
            </section>
            <section>
                <form action="{{ route('admin.setting.update', $setting->id) }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    {{ method_field('put') }}
                    <section class="row">
                        <section class="col-12">
                            <div class="form-group mb-1">
                                <label class="blue" for="title">عنوان سایت</label>
                                <input type="text" class="form-control form-control-sm" name="title" id="title" value="{{ old('title', $setting->title) }}">
                            </div>
                            @error('title')
                            <span class="text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="description">توضیحات سایت</label>
                                <input type="text" class="form-control form-control-sm" name="description" id="description" value="{{ old('description', $setting->description) }}">
                            </div>
                            @error('description')
                            <span class="text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label for="keywords" class="blue">کلمات کلیدی سایت</label>
                                <input type="hidden" class="form-control form-control-sm border-blue" name="keywords" id="keywords" value="{{ old('keywords' , $setting->keywords) }}">
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
                                <label class="blue" for="logo">لوگو</label>
                                <input type="file" class="form-control form-control-sm" name="logo" id="logo">
                            </div>
                            @error('logo')
                            <span class="text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="icon">آیکون</label>
                                <input type="file" class="form-control form-control-sm" name="icon" id="icon">
                            </div>
                            @error('icon')
                            <span class="text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 my-3">
                            <button class="btn btn-md blue-color btn-hover text-white mt-3">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        var tags_input = $('#keywords');
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