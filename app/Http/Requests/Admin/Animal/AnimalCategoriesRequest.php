<?php

namespace App\Http\Requests\Admin\Animal;

use Illuminate\Foundation\Http\FormRequest;

class AnimalCategoriesRequest extends FormRequest
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
                'name'         => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
                'description'  => 'required|min:1',
                'image'        => 'required|image|mimes:png,jpg,jpeg,gif',
                'tags'         => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
                'parent_id'    => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_categories,id',
            ];
        } else {
            return [
                'name'         => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
                'description'  => 'required|min:1',
                'image'        => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'tags'         => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,() ]+$/u',
                'parent_id'    => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_categories,id',
            ];
        }
    }
}
