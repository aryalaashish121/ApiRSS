<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
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
        return [
            'title'=>['required','string','max:55'],
            'description'=>['nullable','string','max:255'],
            'category_id'=>['integer','required'],
        ];
    }

    public function messages()
    {
        return [
            'title.max'=>"Title cannot be longer than 55 char.",
            'description.max'=>"Title cannot be longer than 255 char.",
        ];
        
    }
}
