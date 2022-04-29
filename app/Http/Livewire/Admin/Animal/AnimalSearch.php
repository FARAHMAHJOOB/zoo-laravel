<?php

namespace App\Http\Livewire\Admin\Animal;

use Livewire\Component;
use App\Models\Admin\Animal\Animal;

class AnimalSearch extends Component
{
    public $searchTerm = '';
    public $animals;
    public function render()
    {
        if (empty($this->searchTerm)) {
            $this->animals = Animal::where('name', $this->searchTerm)->get();
        } else {
            $this->animals = Animal::where('name', 'LIKE', '%' . $this->searchTerm . "%")->orWhere('tags', 'LIKE', '%' . $this->searchTerm . '%')->orWhere('english_name', 'LIKE', '%' . $this->searchTerm . '%')->get();
        }
        return view('livewire.admin.animal.animal-search');
    }
}
