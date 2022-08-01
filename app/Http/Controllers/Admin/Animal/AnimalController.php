<?php

namespace App\Http\Controllers\Admin\Animal;

use App\Jobs\ProcessNewAnimal;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use App\Models\Admin\Animal\AnimalMeta;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Animal\AnimalCategory;
use App\Http\Requests\Admin\Animal\AnimalRequest;
use App\Models\Admin\Animal\AnimalProtectiveStatus;


class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $animals = Animal::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.animal.animal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $animalCategories = AnimalCategory::all();
        $protectives = AnimalProtectiveStatus::all();
        return view('admin.animal.animal.create', compact('animalCategories', 'protectives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalRequest $request, ImageService $imageService)
    {
        $inputs = $request->validated();
        // fix image
        $inputs['image'] = $imageService->storeImage($request, 'image', 'animals', 'index');
        //fix date
        $inputs['published_at'] = setDate($request, 'published_at');

        $flag = DB::transaction(function () use ($request, $inputs) {
            $animal = Animal::create($inputs);
            $metas = array_combine($request->meta_key, $request->meta_value);
            foreach ($metas as $key => $value) {
                if ($key && $value) {
                    $meta = AnimalMeta::create([
                        'meta_key' => $key,
                        'meta_value' => $value,
                        'animal_id' => $animal->id
                    ]);
                }
            }
            // ProcessNewAnimal::dispatch($animal->name);
            return true;
        });
        return endTransaction($flag, 'admin.animal.index', 'رکورد جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        return view('admin.animal.animal.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Animal $animal)
    {
        $animalCategories = AnimalCategory::all();
        $protectives = AnimalProtectiveStatus::all();
        return view('admin.animal.animal.edit', compact('animalCategories', 'protectives', 'animal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnimalRequest $request, ImageService $imageService, Animal $animal)
    {
        $inputs = $request->validated();

        //fix date
        $inputs['published_at'] = setDate($request, 'published_at');

        $inputs['image'] = $imageService->storeImage($request, 'image', 'animals', 'index');
        if (!empty($animal->image)) {
            $imageService->deleteDirectoryAndFiles($animal->image['directory']);
        }
        $flag = DB::transaction(function () use ($inputs, $imageService, $animal) {
            $animal->update($inputs);
            return true;
        });
        return endTransaction($flag, 'admin.animal.index', 'ویرایش انجام شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return to_route('admin.animal.index')->with('swal-success', 'رکورد با موفقیت حذف شد');
    }


    public function status(Animal $animal)
    {
        return setStatus($animal);
    }
}
