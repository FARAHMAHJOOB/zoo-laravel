@extends('user.layouts.master')

@section('title')
    سوالات متداول
@endsection
@section('content')
    <div class="row mb-5">
        <h2 class="col-6 tm-text-primary">
            سوالات متداول
        </h2>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <form action="" class="tm-text-primary">
                Page <input type="text" value="1" size="1" class="tm-input-paging tm-text-primary"> of 200
            </form>
        </div>
    </div>
    <div class="row mr-3 mb-5">
        @foreach ($faqs as $faq)
            <div class="col-12 ">
                <div class="d-flex flex-column tm-text-gray">
                    <p class="h5"><a href="">{{ $faq->question }}</a></p>
                    <p class="h6">{!! $faq->answer !!}</p>
                </div>
            </div>
        @endforeach
    </div>
    {{ $faqs->links('user.layouts.pagination') }}
@endsection
