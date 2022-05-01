<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeEmailRequest extends FormRequest
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
            'new_email' => ['required','string','email','max:255','unique:users,email','confirmed'],
            'password' => ['required','password']
        ];
    }

    public function messages()
    {
        return [
            'new_email.required' => 'メールアドレスを入力してください',
            'new_email.string' => 'メールアドレスは文字で入力してください',
            'new_email.email' => '@ が含まれてません',
            'new_email.max' => 'メールアドレスが長過ぎます',
            'new_email.unique' => 'メールアドレスは既に使用されています',
            'new_email.confirmed' => 'メールアドレスが確認用と一致しません',
            'password.required' => 'パスワードを入力してください',
            'password.password' => 'パスワードを確認できません'
        ];
    }
}
