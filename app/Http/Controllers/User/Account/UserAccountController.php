<?php

namespace App\Http\Controllers\User\Account;

use Illuminate\Http\Request;
use App\Models\Admin\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Image\ImageService;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.account.index');
    }


    // public function EditAccountForm()
    // {
    //     return view('user.account.edit-account');
    // }

    public function EditProfileImage(Request $request, ImageService $imageService)
    {
        $user = User::find(Auth::user()->id);
        $inputs = $request->all();
        $inputs['profile_photo_path'] = $imageService->storeImage($request, 'profile_photo_path', 'users', 'save');

        if (!empty($user->profile_photo_path)) {
            $imageService->deleteImage($user->profile_photo_path);
        }

        $user->profile_photo_path = $inputs['profile_photo_path'] ;
        $user->save();
        return response()->json(['status' => true, 'userImg' => asset($user->profile_photo_path)]);
    }


    public function EditAccountInfo(Request $request)
    {
        $inputs = $request->all();
        $user = User::find(Auth::user()->id);
        if ($request->has('first_name')) {
            $user->first_name = convertPersianToEnglish($inputs['first_name']) ;
        } elseif ($request->has('last_name')) {
            $user->last_name = convertPersianToEnglish($inputs['last_name']) ;
        } elseif ($request->has('email')) {
            $user->email = convertPersianToEnglish($inputs['email']) ;
        } elseif ($request->has('mobile')) {
            $user->mobile = convertPersianToEnglish($inputs['mobile']) ;
        } elseif ($request->has('national_code')) {
            $user->national_code = convertPersianToEnglish($inputs['national_code']) ;
        }
        $user->save();
        return response()->json(['status' => true]);
    }

}
