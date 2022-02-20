<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'post/show'){
        return true;
        } else {
        return false;
    }
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required|max:20',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'コメントを入力してください。',
            'message.max' => 'コメントは20文字以内で入力してください。',
        ];
    }
}
