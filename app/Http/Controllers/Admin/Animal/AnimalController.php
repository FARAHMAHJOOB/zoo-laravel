<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use Nette\Schema\Elements\AnyOf;
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
        $animals = Animal::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.animal.index', compact('animals'));
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
        return view('admin.animal.create', compact('animalCategories', 'protectives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'animal');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.animal.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
            if (isset($inputs['currentImage'])) {
                $inputs['image']['currentImage'] = $inputs['currentImage'];
            }
        }
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
            return true;
        });
        if ($flag) {
            return redirect()->route('admin.animal.index')->with('swal-success', 'رکورد جدید با موفقیت ایجاد شد');
        } else {
            return redirect()->route('admin.animal.index')->with('swal-error', 'در درج رکورد مشکلی پیش آمد، مجددا امتحان کنید');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Animal $animal)
    {
        return view('admin.animal.show', compact('animal'));
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
        return view('admin.animal.edit', compact('animalCategories', 'protectives', 'animal'));
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
        $flag = DB::transaction(function () use ($request, $imageService, $animal) {
            $inputs = $request->all();
            //date fixed
            $realTimestampStart = substr($request->published_at, 0, 10);
            $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

            if ($request->hasFile('image')) {
                if (!empty($animal->image)) {
                    $imageService->deleteDirectoryAndFiles($animal->image['directory']);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'animal');
                $result = $imageService->createIndexAndSave($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.market.animal.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            }
            if (isset($inputs['currentImage']) && $request->hasFile('image')) {
                $image = $inputs['image'];
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            } elseif (isset($inputs['currentImage']) && !empty($animal->image)) {
                $image = $animal->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
            // dd($inputs);
            $animal->update($inputs);
            return true;
        });
        if ($flag) {
            return redirect()->route('admin.animal.index')->with('swal-success', 'رکورد با موفقیت ویرایش شد');
        }
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
        return redirect()->route('admin.animal.index')->with('swal-success', 'رکورد با موفقیت حذف شد');
    }


    public function status(Animal $animal)
    {
        if ($animal->getRawOriginal('status') == 0) {
            $animal->status = 1;
        } else {
            $animal->status = 0;
        }
        $result = $animal->save();
        if ($result) {
            if ($animal->getRawOriginal('status') == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }


    public function search(Request $request)
    {
      
    }
}
