<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'prefecture' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ユーザー名は必須です',
            'name.string' => 'ユーザー名は文字列で入力してください',
            'name.max' => 'ユーザー名は255文字以内で入力してください',
            'email.required' => 'メールアドレスは必須です',
            'email.email' => 'メールアドレスは有効なメールアドレスで入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください',
            'phone.required' => '電話番号は必須です',
            'phone.string' => '電話番号は文字列で入力してください',
            'phone.max' => '電話番号は255文字以内で入力してください',
            'postal_code.required' => '郵便番号は必須です',
            'postal_code.string' => '郵便番号は文字列で入力してください',
            'postal_code.max' => '郵便番号は255文字以内で入力してください',
            'prefecture.required' => '都道府県は必須です',
            'prefecture.string' => '都道府県は文字列で入力してください',
            'prefecture.max' => '都道府県は255文字以内で入力してください',
            'address.required' => '住所は必須です',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
        ];
    }
}
