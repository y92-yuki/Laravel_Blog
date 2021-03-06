<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|max:20',
            'message' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $this->title),
            'message' => preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', $this->message),
        ]);
    }
    
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須項目です。',
            'title.max' => 'タイトルは20文字以内で入力してください。',
            'message.required' => '内容は必須項目です。',
        ];
    }
}
