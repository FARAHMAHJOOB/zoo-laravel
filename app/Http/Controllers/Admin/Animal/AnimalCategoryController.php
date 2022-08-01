<?php

namespace App\Http\Controllers\Admin\Animal;

use App\Http\Controllers\Controller;
use App\Models\Admin\Animal\AnimalCategory;
use App\Http\Requests\Admin\Animal\AnimalCategoriesRequest;
use App\Http\Services\Image\ImageService;

class AnimalCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animalCategories = AnimalCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.animal.category.index', compact('animalCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $animalCategories = AnimalCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.animal.category.create', compact('animalCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalCategoriesRequest $request , ImageService $imageService)
    {
        $inputs = $request->validated();
        // fix image
        $inputs['image'] = $imageService->storeImage($request , 'image' , 'animal-category', 'save');
        $animalCategory = AnimalCategory::create($inputs);
        return endTransaction($animalCategory, 'admin.animal.category.index', 'دسته بندی جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AnimalCategory $category)
    {
        return view('admin.animal.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AnimalCategory $category)
    {
        $animalCategories = AnimalCategory::where('parent_id', null)->get()->except($category->id);
        return view('admin.animal.category.edit', compact('animalCategories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnimalCategoriesRequest $request, ImageService $imageService, AnimalCategory $category)
    {
        $inputs = $request->validated();
        // fix image
        $inputs['image'] = $imageService->storeImage($request , 'image' , 'animal-category', 'save');
        if (!empty($category->image)) {
            $imageService->deleteImage($category->image);
        }
        $animalCategory = $category->update($inputs);
        return endTransaction($animalCategory, 'admin.animal.category.index', 'دسته بندی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.animal.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف شد');
    }


    public function status(AnimalCategory $category)
    {
        return setStatus($category);
    }
}
