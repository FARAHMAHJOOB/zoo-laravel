<?php

namespace App\Http\Livewire\Admin\User;

use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\User\User;

class UserSearch extends Component
{
    use WithPagination;
    public $searchTerm = '';
    public $currentPage = 1;

    public function setPage($url)
    {
        $this->currentPage=explode('page=' , $url)[0];
        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $users = User::where('first_name', 'LIKE', $searchTerm)
            ->orWhere('last_name', 'LIKE', $searchTerm)
            ->orWhere('email', 'LIKE', $searchTerm)
            ->paginate(20);
        return view('livewire.admin.user.user-search' , ["users" => $users]);
    }
}
