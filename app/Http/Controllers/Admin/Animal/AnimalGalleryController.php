<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Animal\AnimalGalleryRequest;
use App\Models\Admin\Animal\AnimalImage;
use App\Http\Services\Image\ImageService;

class AnimalGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function allGallery()
    {
        $animals = Animal::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.animal.gallery.all-gallery', compact('animals'));
    }


    public function index(Animal $animal)
    {
        $animalImages = $animal->images;
        return view('admin.animal.gallery.index', compact('animalImages', 'animal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalGalleryRequest $request, ImageService $imageService, Animal $animal)
    {
        $inputs = $request->validated();
        // fix image
        $inputs['image'] = $imageService->storeImage($request , 'animal_image' , 'animal-gallery', 'save');
        $animalImage = AnimalImage::create([
            'animal_image' => $inputs['image'], 'animal_id' => $animal->id , 'status' => 1
        ]);
        return redirect()->back()->with('swal-success' , 'رکورد جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalImage $image)
    {
        $image->delete();
        return redirect()->back()->with('swal-success', 'تصویر با موفقیت حذف شد');
    }


    public function status(AnimalImage $image)
    {
        return setStatus($image);
    }


    public function destroyGallery(Animal $animal)
    {
        $flag = DB::transaction(function () use ($animal) {
            foreach ($animal->images as $image) {
                $image->delete();
            }
            return true;
        });
        return endTransaction($flag, 'admin.animal.gallery.allGallery', 'گالری با موفقیت حذف شد');
    }
}
