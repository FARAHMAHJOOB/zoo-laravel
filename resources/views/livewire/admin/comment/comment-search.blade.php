<section class="row">
    @include('livewire.loading')
    <div wire:offline class="alert alert-danger mx-3 w-100 my-0 font-weight-bold pr-4 alert-dismissible fade show" role="alert">
         ارتباط اینترنت قطع است
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header mb-4">
                <h4>
                    {{ $pageTitle }}
                </h4>
                <section class="d-flex justify-content-between  my-4">
                    <a href="{{ route('admin.comment.readAll') }}"
                    class="btn btn-sm text-white blue-color btn-hover">نشان کردن همه به عنوان خوانده شده</a>
                    <div class="width-13-rem width-md-16-rem">
                        <input type="text" wire:model="searchTerm"
                            class="form-control form-control-sm form-text border-blue" placeholder="جستجو در نظرات..."
                            id="searchInput">
                        <ul class="searchBox list-group width-16-rem width-md-16-rem border" id="searchResult">
                            @if ($searchTerm !== '' && $comments->count() < 1)
                                <li class="list-group-item p-1">نظر پیدا نشد</li>
                            @else
                                <li class="list-group-item p-1" wire:loading>در حال جستجو...</li>
                            @endif
                        </ul>
                    </div>
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
{{ $comments->links('livewire.livewire-paginatore') }}
