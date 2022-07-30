@extends('admin.layouts.master')

@section('title')
نظرات
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
        <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.comment.index') }}"> نظرات </a></li>
        <li class="breadcrumb-item font-size-15 active" aria-current="page"> نمایش نظر</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header mb-4">
                <h5>
                    نمایش نظر
                </h5>
            </section>
            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                <a href="{{ route('admin.comment.index') }}" class="btn btn-sm text-white blue-color btn-hover">بازگشت</a>
            </section>
            <section class="card mb-3">
                <section class="card-header text-dark light-blue font-weight-bold">
                    {{$comment->user->fullName}}
                </section>
                <section class="card-body pb-0">
                    <h5 class="card-title">{{$comment->commentable->name}}</h5>
                    <p class="card-text">{!!$comment->body!!}</p>
                    <p class="mb-1">{{jalaliDate($comment->created_at)}} </p>
                </section>
            </section>
            @if($comment->admin_answer == null)
            <section>
                <form action="{{ route('admin.comment.answer' , $comment->id) }}" method="post">
                    @csrf
                    <section class="row">
                        <section class="col-12 my-2">
                            <div class="form-group mb-0">
                                <label for="" class="font-weight-bold">پاسخ مدیر</label>
                                ‍<textarea class="form-control form-control-sm" rows="4" id="body" name="body">{{ old('body' , $comment->adminAnswerParent->body?? '' ) }}</textarea>
                            </div>
                            @error('body')
                            <span class="text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <button class="btn btn-md text-white blue-color btn-hover mt-3">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>
            @else
            <section class="card mb-3">
                <section class="card-header text-dark light-blue font-weight-bold">
                    نظر اصلی
                </section>
                <section class="card-body pb-0">
                    <p class="card-text">{!!$comment->adminAnswerChild->body ?? ''!!}</p>
                    <p class="mb-1">{{jalaliDate($comment->adminAnswerChild->created_at) ?? ''}} </p>
                </section>
            </section>
            @endif
            @if(count($comment->childs) > 0)
            <section class="main-body-container-header mt-5">
                <h5>
                    پاسخ های کاربران به این نظر: <b class="blue">{{count($comment->childs)  . '  نظر'}} </b>
                </h5>
            </section>
            @foreach($comment->childs as $child)
            <section class="card mb-3 mt-3">
                <section class="card-header text-dark light-blue font-weight-bold">
                    {{$child->user->fullName}}
                </section>
                <section class="card-body pb-3 d-flex justify-content-between">
                    <div>
                        <p class="card-text">{!!$child->body ?? ''!!}</p>
                        <p class="mb-1">{{jalaliDate($child->created_at) ?? ''}} </p>
                    </div>
                    <td class="pl-0">
                        <label title="فعال/غیرفعال">
                            <input id="{{ $child->id }}" onchange="changeStatus('{{ $child->id }}')" data-url="{{ route('admin.comment.status', $child->id) }}" type="checkbox" @if ($child->status === 1)
                            checked
                            @endif>
                        </label>
                    </td>
                </section>
            </section>
            @endforeach
            @endif
        </section>
    </section>
</section>
@endsection


@section('script')
<script type="text/javascript">
    function changeStatus(id) {
        var element = $("#" + id)
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.status) {
                    if (response.checked) {
                        element.prop('checked', true);
                        successToast('نطر فعال شد')
                    } else {
                        element.prop('checked', false);
                        successToast('نظر غیرفعال شد')
                    }
                } else {
                    element.prop('checked', elementValue);
                    errorToast('در تغییر وضعیت مشکلی به جود آمد')
                }
            },
            error: function() {
                element.prop('checked', elementValue);
                errorToast('ارتباط برقرار نشد')
            }
        });
    }
</script>
@endsection
