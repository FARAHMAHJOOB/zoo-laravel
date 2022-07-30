@extends('admin.layouts.master')

@section('title')
پیج جدید
@endsection

@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> محتوی </li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.content.page.index') }}"> پیج ساز </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> پیج جدید </li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    پیج جدید
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.content.page.index') }}" class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                </section>
            </section>
            <section>
                <form action="{{ route('admin.content.page.store') }}" method="post" id="form">
                    @csrf
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="title">عنوان </label>
                                <input type="text" class="form-control form-control-sm" name="title" value="{{ old('title') }}">
                            </div>
                            @error('title')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" class="blue"for="status">وضعیت</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="0" @if(old('status')==0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status')==1) selected @endif>فعال</option>
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
                            <div class="form-group mb-1 pl-md-4">
                                <label for="tags" class="blue">تگ ها</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags" value="{{ old('tags') }}">
                                <select class="select2 form-control form-control-sm col-12" id="select_tags" multiple>
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
                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label class="blue" for="">محتوی</label>
                                <textarea name="body" id="body" class="form-control form-control-sm" rows="6"> {{old('body') }}</textarea>
                            </div>
                            @error('body')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 my-2">
                            <button class="btn btn-md text-white blue-color btn-hover mt-3">ثبت</button>
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
<script>
    CKEDITOR.replace('body');
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
