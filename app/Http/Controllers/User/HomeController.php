<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Admin\Faq\FAQ;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use App\Models\Admin\Content\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Comment\Comment;
use App\Models\Admin\Setting\Setting;
use App\Models\Admin\Animal\AnimalCategory;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $animals = Animal::where('status', 1)->orderByDesc('created_at')->paginate(1);
        return view('user.index', compact('sliders', 'animals'));
    }

    public function animalDetails(Animal $animal)
    {

        return view('user.animal-details', compact('animal'));
    }


    public function categories()
    {
        $categories = AnimalCategory::where('status', 1)->orderByDesc('created_at')->paginate(10);
        return view('user.categories', compact('categories'));
    }

    public function categoriesAnimals(AnimalCategory $category)
    {
        checkStatusRecord($category);
        return view('user.animal-categories', compact('category'));
    }

    public function faqs()
    {
        $faqs = FAQ::where('status', 1)->orderByDesc('created_at')->paginate(4);
        return view('user.faqs', compact('faqs'));
    }
}
