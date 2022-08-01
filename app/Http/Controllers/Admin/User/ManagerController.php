<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Admin\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\User\ManagerRequest;


class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Admins = User::where('user_type', 1)->orderBy('id', 'desc')->get();
        return view('admin.user.manager.index', compact('Admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.manager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagerRequest $request, ImageService $imageService)
    {
        $inputs = $request->validated();
        $inputs['profile_photo_path'] = $imageService->storeImage($request, 'profile_photo_path', 'admins', 'save');
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $user = User::create($inputs);
        return redirect()->route('admin.manager.index')->with('swal-success', 'مدیر جدید با موفقیت ثبت شد');
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
    public function edit(User $admin)
    {
        return view('admin.user.manager.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagerRequest $request, User $admin, ImageService $imageService)
    {
        $inputs = $request->validated();
        $inputs['profile_photo_path'] = $imageService->storeImage($request, 'profile_photo_path', 'admins', 'save');

        if (!empty($admin->profile_photo_path)) {
            $imageService->deleteImage($admin->profile_photo_path);
        }

        $admin->update($inputs);
        return redirect()->route('admin.manager.index')->with('swal-success', 'مدیر با موفقیت ویرایش گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin, ImageService $imageService)
    {
        if (!empty($admin->profile_photo_path)) {
            $imageService->deleteImage($admin->profile_photo_path);
        }
        $admin->delete();
        return to_route('admin.manager.index')->with('swal-success', 'مدیر با موفقیت حذف گردید');
    }



    public function status(User $admin)
    {
        setStatus($admin);
    }
}
