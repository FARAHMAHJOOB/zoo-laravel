@extends('admin.layouts.master')

@section('title')
    گالری
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"> گالری</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        گالری
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div>
                        <a href="{{ route('admin.animal.index') }}"
                            class="btn btn-sm text-white blue-color btn-hover">برگشت</a>
                    </div>
                </section>
                <section id="galleryDiv">
                    <div class="row px-1">
                        @foreach ($animals as $animal)
                            <div class="col-md-2 px-1">
                                <div class="gallery w-100 p-1 rounded">
                                    <a href="{{ route('admin.animal.gallery.index', $animal->id) }}" class="text-decoration-none">
                                        @if ($animal->image)
                                            <img src="{{ asset($animal->image['indexArray'][$animal->image['currentImage']]) }}"
                                                alt="" style="height: 200px;" class="rounded-top">
                                        @else
                                            <h5 style="height: 200px;" class="rounded-top bg-light text-dark p-5 my-0">بدون
                                                تصویر </h5>
                                        @endif
                                    </a>
                                    <div
                                        class="desc d-flex light-blue pb-0 pt-2 px-1 rounded-bottom justify-content-between">
                                        <div class="d-flex">
                                            <h6 class="blue">گالری {{ $animal->name }}</h6>
                                            <span class="blue h6 pt-1 pr-2">{{ count($animal->images) }}</span>
                                        </div>
                                        <form action="{{ route('admin.animal.gallery.destroy', $animal->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-lg btn-hover p-0 delete"
                                                title="حذف کل گالری" id="btnDelete"><i
                                                    class='fa fa-times-circle text-danger'></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')
    @include('alerts.sweetalerts.confirm', [
        'className' => 'delete',
        'message' => 'تمامی عکس های این گالری حذف خواهند شد، مطمئنید؟',
    ])
@endsection
