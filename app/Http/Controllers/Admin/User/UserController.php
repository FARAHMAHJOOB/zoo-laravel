<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Models\Admin\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserRegistered;
use App\Http\Services\Image\ImageService;
use App\Http\Requests\Admin\User\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users=User::where('user_type' , 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.user.user.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, ImageService $imageService)
    {
        $inputs = $request->validated();
        $inputs['profile_photo_path'] = $imageService->storeImage($request, 'profile_photo_path', 'users', 'save');

        $inputs['password'] = Hash::make($request->password);
        $user = User::create($inputs);
        // $details = ['message' => $user->fullName . ' در سایت ثبت نام کرد'];
        // $adminUser = User::where('role_id', 3)->get();
        // $adminUser->notify(new NewUserRegistered($details));
        return redirect()->route('admin.user.index')->with('swal-success', 'کاربر جدید با موفقیت ثبت شد');
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
    public function edit(User $user)
    {
        return view('admin.user.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user, ImageService $imageService)
    {
        $inputs = $request->validated();
        $inputs['profile_photo_path'] = $imageService->storeImage($request, 'profile_photo_path', 'admins', 'save');
        if (!empty($user->profile_photo_path)) {
            $imageService->deleteImage($user->profile_photo_path);
        }
        $user->update($inputs);
        return redirect()->route('admin.user.index')->with('swal-success', 'کاربر با موفقیت ویرایش گردید');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, ImageService $imageService)
    {
        if (!empty($user->profile_photo_path)) {
            $imageService->deleteImage($user->profile_photo_path);
        }
        $user->forceDelete();
        return redirect()->route('admin.user.index')->with('swal-success', 'کاربر با موفقیت حذف گردید');
    }

    public function status(User $user)
    {
        setStatus($user);
    }
}
