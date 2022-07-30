@extends('user.layouts.master')

@section('title')
دسته بندی ها
@endsection
@section('content')
<div class="row mb-4">
    <h2 class="col-6 tm-text-primary">
       دسته بندی ها
    </h2>
    <div class="col-6 d-flex justify-content-end align-items-center">
        <form action="" class="tm-text-primary">
            Page <input type="text" value="1" size="1" class="tm-input-paging tm-text-primary"> of 200
        </form>
    </div>
</div>
<div class="row tm-mb-90 tm-gallery">
    @foreach ($categories as $category)
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5 ">
            <figure class="effect-ming tm-video-item rounded">
                    <img src="{{asset($category->image) }}" alt="{{$category->name}}" class="img-fluid">
                <figcaption class="d-flex align-items-center justify-content-center">
                    <h2>{{$category->name}}</h2>
                    <a href="{{route('home.category-animals' , $category->id)}}">جزییات</a>
                </figcaption>
            </figure>
            <div class="d-flex justify-content-between tm-text-gray">
                <span class="tm-text-gray-light">{{convertEnglishToPersian(jalaliDate($category->created_at , '%Y/%m/%d H:i'))}}</span>
                <span >{{$category->name}}</span>
            </div>
        </div>
    @endforeach
</div>
{{$categories->links('user.layouts.pagination')}}

@endsection



