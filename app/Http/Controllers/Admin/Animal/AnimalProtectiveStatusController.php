<?php

namespace App\Http\Controllers\Admin\Animal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Animal\AnimalProtectiveStatusRequest;
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
    public function store(AnimalProtectiveStatusRequest $request)
    {
        $protectiveStatus = AnimalProtectiveStatus::create($request->validated());
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
    public function update(AnimalProtectiveStatusRequest $request , AnimalProtectiveStatus $status)
    {

        $protectiveStatus = $status->update($request->validated());
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
        return setStatus($status);
    }

}
