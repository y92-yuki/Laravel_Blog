<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'currentPassword' => ['required','password'],
            'newPassword' => ['required','min:8','string','confirmed']
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.required' => 'パスワードを入力してください',
            'currentPassword.password' => 'パスワードが正しくありません',
            'newPassword.required' => '新しいパスワードを入力してください',
            'newPassword.min' => 'パスワードは8文字以上で設定してください',
            'newPassword.string' => 'パスワードは文字で入力してください',
            'newPassword.confirmed' => 'パスワードが確認用と一致しません'
        ];
    }
}
