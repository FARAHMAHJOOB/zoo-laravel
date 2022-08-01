    <div class="row border-top">
        @include('livewire.loading')
        @if (Auth::check())
            <section class="col-12 col-add-comment mt-5">
                <form wire:submit.prevent="addComment" id="addCommentForm">
                    <div class="form-group mb-1" wire:ignore>
                        <label for="body" class="mb-4 h2 tm-text-primary ">دیدگاه شما</label>
                        <textarea data-message="@this" wire:model="body" name="body" id="body"
                            class="form-control form-control-sm required">{{ old('body') }} </textarea>
                    </div>
                    @error('body')
                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between"
                            role="alert">
                            <p class="h5">دیدگاه خود را بنویسید</p>
                            <button type="button" class="close py-0 h-25" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @enderror
                    <div class="col-12 text-left">
                        <button class="btn-more-result p-2 btn-primary text-nowrap mt-4" id="submitCommentBtn">ارسال
                            دیدگاه
                        </button>
                    </div>
                </form>
            </section>
        @else
            <p class="h5 mr-5 pr-5 my-5"> برای ثبت نظر باید در سایت <a
                    href="{{ route('auth.user.login-register-form') }}">ثبت نام </a>
                کنید یا وارد <a href="{{ route('auth.user.login-register-form') }}">حساب کاربری</a> خود شوید. </p>
        @endif
        <h2 class="tm-text-primary mb-5 mr-md-5 pr-md-5">
            نظرات
        </h2>
        <div class="col-12 col-card">
            <div class="card">
                <ul class="list-unstyled">
                    @if (Auth::check() && $unAprovedComments->count() > 0)
                        @foreach ($unAprovedComments as $unAprovedComment)
                            <li class="media my-3">
                                <div class="media-body pl-2">
                                    <div class="media mt-3 comment">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <section class="d-flex align-items-center ">
                                                <img src="{{ asset($unAprovedComment->user->profile_photo_path ?? 'images/users/defultProfile.png') }}"
                                                    class="align-self-center mr-1 my-2">
                                                <span>
                                                    <p class="user-name my-auto font-weight-bold">
                                                        @if (!empty($unAprovedComment->user->first_name) && !empty($unAprovedComment->user->last_name))
                                                            {{ $unAprovedComment->user->fullName }}
                                                        @else
                                                            کاربر
                                                        @endif
                                                    </p>
                                                    <p class="comment-time">
                                                        {{ convertEnglishToPersian(jalaliDate($unAprovedComment->created_at, '%Y/%m/%d H:i')) }}
                                                    </p>
                                                </span>
                                            </section>
                                            <span
                                                class="d-flex flex-column flex-md-row justify-content-center ml-1 mt-1 mt-md-0 ml-md-3 mb-3 ">
                                                <button class="btn btn-warning py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                    title="ویرایش" id="editCommentBtn" onclick="scrollToCommentForm()"
                                                    wire:click='setEditComment({{ $unAprovedComment->id }})'>
                                                    <i class="fa fa-edit text-white " aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-danger py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                    title="حذف"
                                                    wire:click='setDestroyComment({{ $unAprovedComment->id }})'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="btn btn-primary py-1 px-2 mx-1 my-1 my-md-0"
                                                    title="پاسخ" onclick="scrollToCommentForm()"
                                                    wire:click='setParentComment({{ $unAprovedComment->id }} , {{ $unAprovedComment->user->id }})'><i
                                                        class="fa fa-reply"></i></button>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="reply">{!! $unAprovedComment->body !!}
                                            <p class="text-primary h6"> دیدگاه شما پس از تایید توسط
                                                کارشناسان،
                                                نمایش داده خواهد شد.</p>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                    @if ($comments->count() > 0)
                        @foreach ($comments as $comment)
                            <li class="media my-3">
                                <div class="media-body pl-2">
                                    <div class="media mt-3 comment">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <section class="d-flex align-items-center ">
                                                <img src="{{ asset($comment->user->profile_photo_path ?? 'images/users/defultProfile.png') }}"
                                                    class="align-self-center mr-1 my-2">
                                                <span>
                                                    <p class="user-name my-auto font-weight-bold">
                                                        @if (!empty($comment->user->first_name) && !empty($comment->user->last_name))
                                                            {{ $comment->user->fullName }}
                                                        @else
                                                            کاربر
                                                        @endif
                                                    </p>
                                                    <p class="comment-time">
                                                        {{ convertEnglishToPersian(jalaliDate($comment->created_at, '%Y/%m/%d H:i')) }}
                                                    </p>
                                                </span>
                                            </section>
                                            <span
                                                class="d-flex flex-column flex-md-row justify-content-center ml-1 mt-1 mt-md-0 ml-md-3 mb-3 ">
                                                @if (Auth::check())
                                                    @if (Auth::user() == $comment->user)
                                                        <button
                                                            class="btn btn-warning py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                            title="ویرایش" onclick="scrollToCommentForm()"
                                                            wire:click='setEditComment({{ $comment->id }})'>
                                                            <i class="fa fa-edit text-white" aria-hidden="true"></i>
                                                        </button>
                                                        <button
                                                            class="btn btn-danger py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                            title="حذف"
                                                            wire:click='setDestroyComment({{ $comment->id }})'>
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-primary py-1 px-2 mx-1 my-1 my-md-0"
                                                        title="پاسخ" onclick="scrollToCommentForm()"
                                                        wire:click='setParentComment({{ $comment->id }} , {{ $comment->user->id }})'><i
                                                            class="fa fa-reply"></i></button>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <p class="reply">{!! $comment->body !!} </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @foreach ($comment->childs->where('status', 1) as $child)
                                <li class="media my-4 media-reply">
                                    <div class="media-body">
                                        <div class="media mt-3 comment media-comment-reply">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <section class="d-flex align-items-center ">
                                                    <img src="{{ asset($child->user->profile_photo_path ?? 'images/users/defultProfile.png') }}"
                                                        class="align-self-center mr-1 my-2">
                                                    <span>
                                                        <p class="user-name my-auto font-weight-bold">
                                                            @if (!empty($child->user->first_name) && !empty($child->user->last_name))
                                                                {{ $child->user->fullName }}
                                                            @else
                                                                کاربر
                                                            @endif
                                                        </p>
                                                        <p class="comment-time">
                                                            {{ convertEnglishToPersian(jalaliDate($child->created_at, '%Y/%m/%d H:i')) }}
                                                        </p>
                                                    </span>
                                                </section>
                                                <span
                                                    class="d-flex flex-column flex-md-row justify-content-center ml-1 mt-1 mt-md-0 ml-md-3 mb-3 ">
                                                    @if (Auth::check())
                                                        @if (Auth::user() == $child->user)
                                                            <button
                                                                class="btn btn-warning py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                                title="ویرایش" onclick="scrollToCommentForm()"
                                                                wire:click='setEditComment({{ $child->id }})'>
                                                                <i class="fa fa-edit text-white"></i>
                                                            </button>
                                                            <button
                                                                class="btn btn-danger py-1 px-2 rounded mx-1 my-1 my-md-0"
                                                                title="حذف"
                                                                wire:click='setDestroyComment({{ $child->id }})'>
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-primary py-1 px-2 mx-1 my-1 my-md-0"
                                                            title="پاسخ" onclick="scrollToCommentForm()"
                                                            wire:click='setParentComment({{ $comment->id }} , {{ $child->user->id }})'>
                                                            <i class="fa fa-reply"></i></button>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="media-body pl-2">
                                                <p class="reply ">{!! $child->body !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                </ul>
            </div>
        @else
            <p class="h5 mr-5 pr-5 mb-5">تاکنون نظری ثبت نشده است</p>
            @endif
            <div class="row mb-5">
                <div class="col-12 text-left">
                    @if ($comments->total() > 0 && $comments->count() < $comments->total())
                        <button wire:click="loadComments" class="btn-more-result p-2 btn-primary text-nowrap">
                            مشاهده نظرات بیشتر...
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <script src="{{ asset('general-assets/ckeditor/ckeditor.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
        <script>
            // send ckeditor data to component
            const editor = CKEDITOR.replace('body');
            document.querySelector("#submitCommentBtn").addEventListener("click", () => {
                @this.set('body', editor.getData());
            });


            // clear ckeditor after register comment
            window.addEventListener('clear-ckeditor', function() {
                @this.set('body', editor.setData(''));
            });

            window.addEventListener('commentWillEdit', function(e) {
                @this.set('body', editor.setData(e.detail.commentText));
            });

            // show confirmation modal to delete comment
            window.addEventListener('show-confirm-alert', function(e) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1 rounded',
                        cancelButton: 'btn btn-danger mx-1 rounded'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'اخطار',
                    text: "نظر حذف شود؟",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'حذف',
                    cancelButtonText: 'انصراف',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value == true) {
                        window.livewire.emit('destroyCommentConfirmed');
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'کنسل شد',
                            'نظر حذف نشد',
                            'error'
                        )
                    }
                })
            });
        </script>

    </div>
