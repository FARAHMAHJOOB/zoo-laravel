@extends('admin.layouts.master')

@section('title')
    نظرات
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"> نظرات</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header mb-4">
                    <h4>
                        {{ $pageTitle }}
                    </h4>
                    <section class="d-flex justify-content-between  my-4">
                        <a href="{{ route('admin.comment.readAll') }}"
                        class="btn btn-sm text-white blue-color btn-hover">نشان کردن همه به عنوان خوانده شده</a>
                    </section>
                </section>
                <div class="table-responsive border">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="light-blue">
                                <th class="py-2">#</th>
                                <th class="py-2"> متن نظر</th>
                                <th class="py-2">نویسنده ی نظر</th>
                                <th class="py-2">نام حیوان</th>
                                <th class="py-2">پاسخ به</th>
                                <th class="py-2">وضعیت نمایش</th>
                                <th class="text-left py-2">تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr>
                                    <th class="">{{ $loop->iteration }} @if ($comment->seen == 0 && $comment->admin_answer == 0)
                                            <sup class="badge badge-danger badge-pill">جدید</sup></th>
                            @endif
                            <td class="">{!! Str::limit($comment->body, 40) !!}</td>
                            <td class=""
                                title="{{ $comment->user->email . ' - ' . $comment->user->mobile }}">
                                {{ $comment->user->fullName }}</td>
                            <td class="" title="{{ $comment->commentable->summary }}">
                                {{ $comment->commentable->name }}</td>
                            <td class="">
                                @if ($comment->parent)
                                    <a href="{{ route('admin.comment.show', $comment->parent->id) }}"
                                        class="text-decoration-none">{!! Str::limit($comment->parent->body, 20) !!}</a>@elseاصلی
                                @endif
                            </td>
                            <td>
                                <label class="pointer">
                                    <input class="pointer" id="{{ $comment->id }}" onchange="changeStatus('{{ $comment->id }}')"
                                        data-url="{{ route('admin.comment.status', $comment->id) }}" type="checkbox"
                                        @if ($comment->status === 1) checked @endif>
                                </label>
                            </td>
                            <td class="text-left ltr d-flex pl-0">
                                <form action="{{ route('admin.comment.destroy', $comment->id) }}" method="POST"
                                    title="حذف">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i
                                            class="fa fa-times-circle text-danger"></i></button>
                                </form>
                                <a href="{{ route('admin.comment.show', $comment->id) }}"
                                    class="btn btn-lg py-0 btn-hover px-1" title="جزییات"><i
                                        class="fa fa-info-circle blue"></i></a>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </section>
    {{ $comments->links() }}

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
    @include('alerts.sweetalerts.confirm', [
        'className' => 'delete',
        'message' => 'نظر حذف شود؟',
    ])
@endsection
