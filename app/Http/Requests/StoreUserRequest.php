<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'register_email' => 'required|email|max:255',
            'register_password' => 'required|confirmed|min:8',
            'phone' => 'required',
            'address' => 'required|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $phone = $this->phone;
            $phone = str_replace('-', '', $this->phone);

            if (!preg_match('/^\d{11}$/', $phone)) {
                $validator->errors()->add('phone', '電話番号を正しく入力してください');
            }

            $postal1 = $this->postal_code1;
            $postal2 = $this->postal_code2;

            $postal = $postal1 . $postal2;

            if (!preg_match('/^\d{7}$/', $postal)) {
                $validator->errors()->add('postal_code', '郵便番号を正しく入力してください');
            }

            session()->flash('auth_tab', 'register');

        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ユーザー名は必須です',
            'name.string' => 'ユーザー名は文字列で入力してください',
            'name.max' => 'ユーザー名は255文字以内で入力してください',
            'register_email.required' => 'メールアドレスは必須です',
            'register_email.email' => 'メールアドレスは有効なメールアドレスで入力してください',
            'register_email.max' => 'メールアドレスは255文字以内で入力してください',
            'register_password.required' => 'パスワードは必須です',
            'register_password.confirmed' => 'パスワードが一致しません',
            'register_password.min' => 'パスワードは8文字以上で入力してください',
            'phone.required' => '電話番号は必須です',
            'address.required' => '住所は必須です',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
        ];
    }
}
