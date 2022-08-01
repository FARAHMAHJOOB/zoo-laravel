<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ContentSliderRequest;
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
    public function store(ContentSliderRequest $request, ImageService $imageService)
    {

        $inputs = $request->validated();

        $inputs['image'] = $imageService->storeImage($request, 'image', 'slider', 'save');
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
        return view('admin.content.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentSliderRequest $request, Slider $slider, ImageService $imageService)
    {
        $inputs = $request->validated();
        $inputs['image'] = $imageService->storeImage($request, 'image', 'slider', 'save');
        if (!empty($slider->image)) {
            $imageService->deleteImage($slider->image);
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
        return setStatus($slider);
    }
}
