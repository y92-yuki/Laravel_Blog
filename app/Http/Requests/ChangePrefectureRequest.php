<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePrefectureRequest extends FormRequest
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
            'pref' => ['integer','between:1,47'],
            'password' => ['required','password']
        ];
    }

    public function messages() {
        return [
            'pref.between' => '地域を選択してください',
            'password.required' => 'パスワードを入力してください',
            'password.password' => 'パスワードを確認できません'
        ];
    }
}
