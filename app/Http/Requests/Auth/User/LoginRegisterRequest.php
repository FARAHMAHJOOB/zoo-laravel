<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class LoginRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $route= Route::current();
        if ($route->getName() == 'auth.user.login-register') {
            return [
                'id' => 'required|min:11|max:64|regex:/^[a-zA-Z0-9۰-۹_.@\+]*$/',
             ];
        }elseif ($route->getName() == 'auth.user.login-register-confirm') {
            return [
                'otp' => 'required|digits:6',
             ];
        }

     }


     public function attributes(){
         return [
             'id'  => 'ایمیل یا شماره موبایل',
             'otp' => 'کد تایید'
         ];
     }
}
