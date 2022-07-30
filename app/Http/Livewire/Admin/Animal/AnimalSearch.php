<?php

namespace App\Http\Livewire\Admin\Animal;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Animal\Animal;
use Illuminate\Pagination\Paginator;

class AnimalSearch extends Component
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
        $animals = Animal::where('name', 'LIKE', $searchTerm)
            ->orWhere('tags', 'LIKE', $searchTerm)
            ->orWhere('english_name', 'LIKE', $searchTerm)
            ->orWhere('scntf_name', 'LIKE', $searchTerm)
            ->paginate(20);
        return view('livewire.admin.animal.animal-search' , ["animals" => $animals]);
    }
}
