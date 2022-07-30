<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {

            return [
                'first_name'         => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'last_name'          => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'mobile'             => ['required', 'digits:11', 'unique:users'],
                'email'              => ['required', 'string', 'email', 'unique:users'],
                'password'           => ['required', 'unique:users', Password::min(8)->letters()->mixedCase()->numbers()->uncompromised(), 'confirmed'],
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'activation'         => 'required|numeric|in:0,1',
            ];
        } else {
            return [
                'first_name'         => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'last_name'          => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'national_code'      => ['nullable','numeric',Rule::unique('users')->ignore($this->user)],

            ];
        }
    }
}
