<?php

namespace App\Http\Controllers\Admin\Animal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Animal\Animal;
use App\Http\Controllers\Controller;
use App\Models\Admin\Animal\AnimalImage;
use App\Http\Services\Image\ImageService;

class AnimalGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Animal $animal)
    {
        $animalImages=$animal->images;
        return view('admin.animal.gallery.index', compact('animalImages' , 'animal'));
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
    public function store(Request $request , ImageService $imageService ,Animal $animal)
    {
        $validated = $request->validate([
            'animal_image.*' => 'required|image|mimes:png,jpg,jpeg,gif',
        ]);
        // dd($request->animal_image[0]);

        if ($request->hasFile('animal_image')) {
            $flag = DB::transaction(function () use ($request, $imageService, $animal) {
                $inputs = $request->all();
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'animal-gallery');
                foreach ($inputs['animal_image'] as $value) {
                    $result = $imageService->save($value);
                    if ($result === false) {
                        return redirect()->route('admin.animal.gallery.index', $animal->id)->with('swal-error', 'آپلود عکس با خطا مواجه شد');
                    }
                    $animalImage = AnimalImage::create([
                        'animal_image' => $result, 'animal_id' => $animal->id ,'status' => 1
                    ]);
                }
                return true;
            });
            if ($flag) {

                return redirect()->route('admin.animal.gallery.index', $animal->id)->with('swal-success', 'گالری با موفقیت ثبت شد');
            }
        } else {
            return redirect()->route('admin.animal.gallery.index', $animal->id)->with('swal-error', 'عکسی برای آپلود یافت نشد');
        }
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
    public function destroy($id)
    {
        //
    }

    
    public function status(AnimalImage $image)
    {
        if ($image->status == 0) {
            $image->status = 1;
        } else {
            $image->status = 0;
        }
        $result = $image->save();
        if ($result) {
            if ($image->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
