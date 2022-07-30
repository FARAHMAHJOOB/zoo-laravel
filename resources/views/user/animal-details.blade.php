@extends('user.layouts.master')
@section('title')
    {{ $animal->name }}
@endsection

@section('content')
    <div class="container-fluid tm-container-content tm-mt-60 pt-5 border-top mt-0">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">{{ $animal->name }}</h2>
        </div>
        <div class="row tm-mb-90">
            <div class="col-xl-4 col-md-4 col-sm-12">
                <img src="{{ asset($animal->image['indexArray'][$animal->image['currentImage']]) }}" alt="Image"
                    class="img-fluid">
            </div>
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="tm-bg-gray tm-video-details ">
                    <div class="text-right mb-3 mr-0">
                        <ul class="navbar-nav pr-0">
                            <li class="nav-item mr-0">
                                نام انگلیسی : {{ $animal->english_name }}
                            </li>
                            <li class="nav-item mr-0">
                                نام علمی : {{ $animal->scntf_name }}
                            </li>
                            <li class="nav-item mr-0">
                                دسته : {{ $animal->category->name }}
                            </li>
                            <li class="nav-item mr-0">
                                وضعیت حفاظتی : {{ $animal->protective->title }}
                            </li>
                            <li class="nav-item mr-0">
                                قد : {{ $animal->height }} سانتی متر
                            </li>
                            <li class="nav-item mr-0">
                                وزن : {{ $animal->weight }} کیلوگرم
                            </li>
                            @foreach ($animal->metas as $meta)
                                <li class="nav-item mr-0">
                                    {{ $meta->meta_key }} : {{ $meta->meta_value }}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    <p class="mb-4">
                        {{ $animal->summary }}
                    </p>
                    وضعیت حفاظتی :
                    <p class="mb-4">
                        {{ $animal->threatening_factors }}
                    </p>
                    زیستگاه :
                    <p class="mb-4">
                        {{ $animal->habitat }}
                    </p>
                    توضیحات :
                    <p class="mb-4">
                        {!! $animal->description !!}
                    </p>

                </div>
            </div>
        </div>
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                گالری {{ $animal->name }}
            </h2>
        </div>
        <div class="row mb-3 tm-gallery">
            @foreach ($animal->images->where('status',1) as $image)
                <div class="col-xl-3 col-md-8 col-sm-6 col-12 mb-5">
                    <figure class="effect-ming tm-video-item">
                        <img src="{{ asset($image->animal_image) }}" alt="Image" class="">
                        <figcaption class="d-flex align-items-center justify-content-center">
                            <h2> {{ $animal->english_name }}</h2>
                            <a href="{{ url($image->animal_image) }}" target="_blanket">مشاهده</a>
                        </figcaption>
                    </figure>
                    <div class="d-flex justify-content-between tm-text-gray">
                        <span class="tm-text-gray-light">{{ convertEnglishToPersian(jalaliDate($image->created_at, '%Y/%m/%d H:i')) }}</span>
                        <span class="tm-text-gray-light">{{ $animal->name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        @livewire('user.comment-listing', ['animal' => $animal->id])
    </div>
@endsection
@section('script')

    <script>
        window.addEventListener('swal-success', function(e) {
            Swal.fire({
                icon: 'success',
                text: e.detail.text,
                title: 'عملیات موفق'
            })
        });
        window.addEventListener('swal-error', function(e) {
            Swal.fire({
                icon: 'error',
                text: e.detail.text,
                title: 'عملیات ناموفق'
            })
        });
    </script>
    <script>
        function scrollToCommentForm() {
            $('html, body').animate({
                scrollTop: $('#addCommentForm').offset().top
            }, 500);
        };
    </script>




@endsection
