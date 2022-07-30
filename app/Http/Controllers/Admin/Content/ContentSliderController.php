<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\Slider;
use Illuminate\Http\Request;

class ContentSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('admin.content.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.content.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , ImageService $imageService)
    {
        $validated = $request->validate([
            'image'  => 'required|image|mimes:png,jpg,jpeg,gif',
            'alt'    => 'nullable|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status' => 'required|numeric|in:0,1',
            'url'    => 'nullable|max:500',
        ]);
        $inputs=$request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'slider');
            $result = $imageService->save($request->file('image'));
        }
        if ($result === false) {
            return redirect()->route('admin.content.slider.create')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
        }
        $inputs['image'] = $result;
        Slider::create($inputs);
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلاید جدید با موفقیت ثبت گردید');
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
    public function edit(Slider $slider)
    {
        return view('admin.content.slider.edit' , compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider , ImageService $imageService)
    {
        $validated = $request->validate([
            'image'  => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'alt'    => 'nullable|max:120|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status' => 'required|numeric|in:0,1',
            'url'    => 'nullable|max:500',
        ]);
        $inputs=$request->all();
        if ($request->hasFile('image')) {
            if (!empty($slider->image)) {
                $imageService->deleteImage($slider->image);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'slider');
            $result = $imageService->save($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.slider.edit' , $slider->id)->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $slider->update($inputs);
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلاید با موفقیت ویرایش گردید');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.content.slider.index')->with('swal-success', 'اسلاید با موفقیت حذف گردید');
    }

    public function status(Slider $slider)
    {
        if ($slider->getRawOriginal('status') == 0) {
            $slider->status = 1;
        } else {
            $slider->status = 0;
        }
        $result = $slider->save();
        if ($result) {
            if ($slider->getRawOriginal('status') == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
