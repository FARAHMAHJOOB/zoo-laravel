@extends('admin.layouts.master')
@section('title')
ویرایش دسته بندی
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.category.index') }}"> دسته بندی حیوانات</a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> ویرایش دسته بندی </li>
    </ol>
</nav>

<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    ویرایش دسته بندی
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <div>
                    <a href="{{route('admin.animal.category.index')}}" class="btn btn-sm text-white blue-color btn-hover">بازگشت </a>
                </div>
            </section>
            <div>
                <form action="{{ route('admin.animal.category.update' , $category->id) }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    @method('put')
                    <section class="row">
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="name">نام دسته</label>
                                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ old('name',$category->name) }}">
                            </div>
                            @error('name')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>

                            @enderror
                        </section>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <section class="col-10 my-2">
                                    <div class="form-group mb-1">
                                        <label class="blue"  for="image">عکس</label>
                                        <input type="file" class="form-control form-control-sm" id="image" name="image">
                                    </div>
                                    @error('image')
                                    <span class="text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @if($category->image)
                                <section class="col-2">
                                    <img src="{{asset($category->image) }}" alt="" width="70" height="50" class="mt-3">
                                </section>
                                @endif
                            </div>
                        </div>
                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="tags">تگ ها</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags" value="{{ old('tags',$category->tags) }}">
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
                                <label class="blue"  for="parent_id">دسته والد</label>
                                <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                                    <option value="">دسته اصلی</option>
                                    @foreach($animalCategories as $animalCategory)
                                    <option value="{{$animalCategory->id}}" @if(old('parent_id' , $category->parent_id) == $animalCategory->id) selected @endif>{{$animalCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 my-2">
                            <div class="form-group mb-1">
                                <label class="blue"  for="description">توضیحات</label>
                                <textarea class="form-control form-control-sm" id="description" name="description">{{ old('description', $category->description) }}</textarea>
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
                            <button class="btn btn-md text-white blue-color btn-hover">ثبت</button>
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
    CKEDITOR.replace('description');
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
