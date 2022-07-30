<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use App\Models\Admin\Content\Menu;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\ContentMenuRequest;

class ContentMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('admin.content.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::where('parent_id' , null)->get();
        return view('admin.content.menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContentMenuRequest $request)
    {
        Menu::create($request->all());
        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منو جدید با موفقیت ثبت گردید');
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
    public function edit(Menu $menu)
    {
        $menus = Menu::where('parent_id' , null)->get()->except($menu->id);
        return view('admin.content.menu.edit', compact('menu' , 'menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContentMenuRequest $request, Menu $menu)
    {
        $menu->update($request->all());
        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منو با موفقیت ویرایش گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منو با موفقیت حذف گردید');
    }



    public function status(Menu $menu)
    {
        $menu->status = $menu->status == 0 ? 1 : 0;
        $result = $menu->save();
        if ($result) {
            if ($menu->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
