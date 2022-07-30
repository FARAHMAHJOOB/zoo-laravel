<?php

namespace App\Http\Livewire\Admin\Comment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Animal\Animal;
use Illuminate\Pagination\Paginator;
use App\Models\Admin\Comment\Comment;

class CommentSearch extends Component
{
    use WithPagination;
    public $searchTerm = '';
    public $currentPage = 1;
    public $commentGroup;
    public $pageTitle;
    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[0];
        Paginator::currentPageResolver(function () {
            return $this->currentPage;
        });
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        if ($this->commentGroup == 1) {
            $comments = Comment::where('commentable_type', Animal::class)->where('seen', 0)
            ->where('body', 'LIKE', $searchTerm)->orderBy('created_at', 'desc');
        } elseif ($this->commentGroup == 2) {
            $comments = Comment::where('commentable_type', Animal::class)->where('status', 1)
            ->where('body', 'LIKE', $searchTerm)->orderBy('created_at', 'desc');
        } elseif ($this->commentGroup == 3) {
            $comments = Comment::where('commentable_type', Animal::class)->where('status', 0)
            ->where('body', 'LIKE', $searchTerm)->orderBy('created_at', 'desc');
        } else {
            $comments = Comment::where('commentable_type', Animal::class)->
            where('body', 'LIKE', $searchTerm)->orderBy('created_at', 'desc');
        }
        return view('livewire.admin.comment.comment-search', ["comments" => $comments->paginate(10),"pageTitle"=>$this->pageTitle]);
    }
}
