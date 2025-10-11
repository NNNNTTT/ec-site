<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
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
            'slug' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品カテゴリー名は必須です',
            'name.string' => '商品カテゴリー名は文字列で入力してください',
            'name.max' => '商品カテゴリー名は255文字以内で入力してください',
            'slug.required' => 'スラッグは必須です',
            'slug.string' => 'スラッグは文字列で入力してください',
            'slug.max' => 'スラッグは255文字以内で入力してください',
        ];
    }
}
