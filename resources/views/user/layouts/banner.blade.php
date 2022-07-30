<div class="swiper">
    <div class="parallax-bg" style="background-image:url(path/to/image.jpg)" data-swiper-parallax="-23%"></div>
    <div class="swiper-wrapper">

        @foreach ($sliders as $slider)
            <div class="swiper-slide"> <img src="{{ asset($slider->image) }}" alt="{{ $slider->alt }}">
                 <div data-swiper-parallax-opacity="0.5">I will change opacity</div>
            </div>
        @endforeach
        ...
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-scrollbar"></div>
</div>
