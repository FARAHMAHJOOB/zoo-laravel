<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
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
        $flag = DB::transaction(function () use ($request, $imageService) {
            $inputs = $request->all();
            if ($request->hasFile('image')) {
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'animal-category');
                $result = $imageService->save($request->file('image'));
            }
            if ($result === false) {
                return redirect()->route('admin.animal.category.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
            $animalCategory = AnimalCategory::create($inputs);
            return true;
        });
        if ($flag) {
            return redirect()->route('admin.animal.category.index')->with('swal-success', 'دسته بندی جدید با موفقیت ثبت شد');
        }
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
        return view('admin.animal.category.edit', compact('animalCategories' , 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnimalCategoriesRequest $request , ImageService $imageService,AnimalCategory $category)
    {
        $flag = DB::transaction(function () use ($request, $imageService, $category) {
            $inputs = $request->all();
            if ($request->hasFile('image')) {
                if (!empty($category->image)) {
                    $imageService->deleteImage($category->image);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'animal-category');
                $result = $imageService->save($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.animal.category.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            }
            $animalCategory = $category->update($inputs);
            return true;
        });
        if ($flag) {
            return redirect()->route('admin.animal.category.index')->with('swal-success', 'دسته بندی با موفقیت ویرایش شد');
        }
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
        if ($category->getRawOriginal('status') == 0) {
            $category->status = 1;
        } else {
            $category->status = 0;
        }
        $result = $category->save();
        if ($result) {
            if ($category->getRawOriginal('status') == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
