<?php

namespace App\Http\Requests\Admin\Animal;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'name'                => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,)( ]+$/u',
                'english_name'        => 'Nullable|regex:/^[a-zA-Z0-9\-.,)( ]+$/u',
                'scntf_name'          => 'Nullable|regex:/^[a-zA-Z0-9\-.,)( ]+$/u',
                'description'         => 'required|min:2',
                'summary'             => 'required|min:2',
                'threatening_factors' => 'Nullable|min:2',
                'habitat'             => 'Nullable|min:2',
                'weight'              => 'required|max:1000|min:1',
                'height'              => 'required|max:1000|min:1',
                'image'               => 'required|image|mimes:png,jpg,jpeg,gif',
                'status'              => 'required|numeric|in:0,1',
                'tags'                => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'category_id'         => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_categories,id',
                'protective_id'       => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_protective_status,id',
                'published_at'        => 'required|numeric',
            ];
        }
        else{
            return [
                'name'                => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,)( ]+$/u',
                'english_name'        => 'Nullable|regex:/^[a-zA-Z0-9\-.,)( ]+$/u',
                'scntf_name'          => 'Nullable|regex:/^[a-zA-Z0-9\-.,)( ]+$/u',
                'description'         => 'required|min:2',
                'summary'             => 'required|min:2',
                'threatening_factors' => 'Nullable|min:2',
                'habitat'             => 'Nullable|min:2',
                'weight'              => 'required|max:1000|min:1',
                'height'              => 'required|max:1000|min:1',
                'image'               => 'Nullable|image|mimes:png,jpg,jpeg,gif',
                'status'              => 'required|numeric|in:0,1',
                'tags'                => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'category_id'         => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_categories,id',
                'protective_id'       => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:animal_protective_status,id',
                'published_at'        => 'required|numeric',
            ];
        }
    }
}
