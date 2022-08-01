<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Comment\Comment;

class CommentListing extends Component
{
    use WithPagination;
    public $animal;
    public $pageNumber = 2;
    public $body;
    public $parent_id;
    public $answered_id;
    public $destroyComment;
    public $editComment;

    protected $rules = ['body' => 'required'];

    protected $listeners = ['destroyCommentConfirmed' => 'destroyComment'];

    public function setEditComment($editCommentId)
    {
        $this->parent_id   = null;
        $this->editComment = $editCommentId;
        $commentWillEdit   = Comment::find($this->editComment);
        $this->dispatchBrowserEvent('commentWillEdit', ['commentText' => $commentWillEdit->body]);
    }

    public function setDestroyComment($destroyComment)
    {
        $this->destroyComment = Comment::find($destroyComment);
        $this->dispatchBrowserEvent('show-confirm-alert');
    }
    public function destroyComment()
    {
        if ($this->destroyComment) {
            $this->destroyComment->forceDelete();
            $this->destroyComment = null;
            $this->dispatchBrowserEvent('swal-success', ['text' => 'نظر شما با موفقیت حذف گردید']);
        }
    }
    public function setParentComment($parentComment, $answered_id)
    {
        $this->editComment = null;
        $this->parent_id   = $parentComment;
        $this->answered_id = $answered_id;
    }
    public function addComment()
    {
        $this->validate();
        if ($this->parent_id == null && $this->editComment == null) {
            $newComment = Comment::create([
                'body'             => $this->body,
                'author_id'        => Auth::user()->id,
                'commentable_id'   => $this->animal,
                'commentable_type' => 'App\Models\Admin\Animal\Animal'
            ]);
            $this->sendResponse($newComment ,  'دیدگاه شما ثبت گردید، پس از تایید مدیر، در سایت نمایش داده خواهد شد' ,  $this->body);
        } elseif ($this->parent_id !== null && $this->editComment == null) {
            $answerComment = Comment::create([
                'answered_id'      => $this->answered_id,
                'parent_id'        => $this->parent_id,
                'body'             => $this->body,
                'author_id'        => Auth::user()->id,
                'commentable_id'   => $this->animal,
                'commentable_type' => 'App\Models\Admin\Animal\Animal'
            ]);
            $this->sendResponse($answerComment , 'پاسخ شما ثبت گردید، پس از تایید مدیر، در سایت نمایش داده خواهد شد' ,  $this->body);


        } elseif ($this->editComment !== null && $this->parent_id == null) {
            $commentWillEdit = Comment::findOrFail($this->editComment);
            $editedComment = $commentWillEdit->update([
                'body'   => $this->body,
                'status' => 0,
            ]);
            $this->sendResponse($editedComment ,  'نظر ویرایش گردید، پس از تایید کارشناس، در سایت نمایش داده خواهد شد.' ,  $this->editComment);

        }
    }
    public function sendResponse($var , $message , $clearVar)
    {
        if ($var) {
            $this->dispatchBrowserEvent('swal-success', ['text' => $message]);
            $this->dispatchBrowserEvent('clear-ckeditor', 'clear-ckeditor');
           $clearVar = '';
        } else {
            $this->dispatchBrowserEvent('swal-error', ['text' => 'در ثبت عملیات مشکلی پیش آمد']);
        }
    }

    public function loadComments()
    {
        $this->pageNumber += 2;
    }
    public function render()
    {
        $comments = Comment::where('commentable_id', $this->animal)
            ->where('commentable_type', 'App\Models\Admin\Animal\Animal')
            ->where('parent_id', null)->where('status', 1)->orderByDesc('created_at')
            ->paginate($this->pageNumber);
        if (Auth::check()) {
            $unAprovedComments = Comment::where('author_id', Auth::user()->id)->where('commentable_id', $this->animal)
                ->where('commentable_type', 'App\Models\Admin\Animal\Animal')
                ->where('status', 0)->orderByDesc('created_at')->get();
            return view('livewire.user.comment-listing', compact('comments', 'unAprovedComments'));
        } else {
            return view('livewire.user.comment-listing', compact('comments'));
        }
    }
}
