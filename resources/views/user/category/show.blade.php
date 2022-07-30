@extends('user.layouts.master')

@section('title')
    {{ $category->name }}
@endsection
@section('content')
    <div class="row mb-4">
        <h2 class="col-6 tm-text-primary">
            {{ $category->name }}
        </h2>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <form action="" class="tm-text-primary">
                Page <input type="text" value="1" size="1" class="tm-input-paging tm-text-primary"> of 200
            </form>
        </div>
    </div>
    <div class="row tm-mb-90 tm-gallery">
        @if ($category->animals->count() > 0)
            @foreach ($category->animals as $animal)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                    <figure class="effect-ming tm-video-item rounded">
                        <img src="{{ asset($animal->image['indexArray'][$animal->image['currentImage']]) }}" alt=""
                            class="img-fluid">
                        <figcaption class="d-flex align-items-center justify-content-center">
                            <h2>{{ $animal->name }}</h2>
                            <a href="{{ route('home.animal', [$animal->id , $animal->slug ]) }}">جزییات</a>
                        </figcaption>
                    </figure>
                    <div class="d-flex justify-content-between tm-text-gray">
                        <span class="tm-text-gray-light">{{ convertEnglishToPersian(jalaliDate($animal->created_at, '%Y/%m/%d H:i')) }}</span>
                        <span>9,906 بازدید</span>
                    </div>
                </div>
            @endforeach
        @else
            <p class="h5 my-5 text-dark bg-light py-5 text-center rounded">رکوردی برای این دسته بندی وجود ندارد</p>
        @endif
    </div>
@endsection
