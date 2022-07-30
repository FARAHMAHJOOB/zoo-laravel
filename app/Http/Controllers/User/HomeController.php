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
        $animals = Animal::where('status', 1)->orderByDesc('id')->paginate(1);
        return view('user.index', compact('sliders', 'animals'));
    }
}
