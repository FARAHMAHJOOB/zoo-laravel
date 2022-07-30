<?php

namespace App\Http\Controllers\Admin\Animal;

use App\Http\Controllers\Controller;
use App\Models\Admin\Animal\AnimalProtectiveStatus;
use Illuminate\Http\Request;

class AnimalProtectiveStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $protectiveStatus = AnimalProtectiveStatus::orderBy('created_at', 'desc')->get();
        return view('admin.animal.protective-status.index', compact('protectiveStatus'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
            'description'  => 'required|min:1',
        ]);

        $protectiveStatus = AnimalProtectiveStatus::create($request->all());
        return redirect()->route('admin.animal.protectiveStatus.index')->with('swal-success', ' وضعیت حفاظتی جدید با موفقیت ایجاد شد');

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
    public function edit(AnimalProtectiveStatus $status)
    {
        return view('admin.animal.protective-status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , AnimalProtectiveStatus $status)
    {
        $validated = $request->validate([
            'title'        => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
            'description'  => 'required|min:1',
        ]);

        $protectiveStatus = $status->update($request->all());
        return redirect()->route('admin.animal.protectiveStatus.index')->with('swal-success', ' وضعیت حفاظتی با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnimalProtectiveStatus $status)
    {
        $status->delete();
        return redirect()->route('admin.animal.protectiveStatus.index')->with('swal-success', ' وضعیت حفاظتی با موفقیت حذف شد');
    }

    
    public function status(AnimalProtectiveStatus $status)
    {
        if ($status->getRawOriginal('status') == 0) {
            $status->status = 1;
        } else {
            $status->status = 0;
        }
        $result = $status->save();
        if ($result) {
            if ($status->getRawOriginal('status') == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
