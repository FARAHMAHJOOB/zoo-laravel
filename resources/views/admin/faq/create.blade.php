@extends('admin.layouts.master')

@section('title')
ایجاد سوال متداول
@endsection


@section('content')
<nav aria-label="breadcrumb ">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"><a href="{{route('admin.home')}}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{route('admin.faq.index')}}"> سوالات متداول</a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> سوال جدید</li>
    </ol>
</nav>

<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                  سوال جدید
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.faq.index') }}" class="btn blue-color text-white btn-hover btn-sm">بازگشت</a>
                </section>

                <div>
                    <form action="{{ route('admin.faq.store') }}" method="post" id="form">
                       @csrf
                    <section class="row">
                            <section class="col-12 my-2">
                                <div class="form-group mb-1">
                                    <label class="blue"  for="">پرسش</label>
                                    <input type="text" class="form-control form-control-sm" id="question" name="question" value="{{ old('question') }}">
                                </div>
                                @error('question')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group mb-1">
                                    <label class="blue"  for="tags">تگ ها</label>
                                    <input type="hidden" class="form-control form-control-sm" name="tags" id="tags" value="{{ old('tags') }}">
                                    <select class="select2 form-control form-control-sm" id="select_tags" multiple>
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
                                    <label class="blue"  for="status">وضعیت</label>
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="0" @if( old ('status')==0) selected @endif>غیرفعال</option>
                                        <option value="1" @if( old ('status')==1) selected @endif>فعال</option>
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
                                    <label class="blue"  for="">پاسخ</label>
                                    <textarea name="answer" id="answer" class="form-control form-control-sm" rows="4">{{ old('answer') }}</textarea>
                                </div>
                                @error('answer')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <button class="btn blue-color text-white btn-hover btn-md mt-3">ثبت</button>
                            </section>
                        </section>
                    </form>
                </div>
            </section>
        </section>
    </section>
</section>
@endsection

@section('script')
<script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('answer');
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
