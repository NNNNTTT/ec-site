<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'price' => 'required|integer',
            'description' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'price.required' => '価格は必須です',
            'price.integer' => '価格は整数で入力してください',
            'description.required' => '商品説明は必須です',
            'description.string' => '商品説明は文字列で入力してください',
            'stock.required' => '在庫数は必須です',
            'stock.integer' => '在庫数は整数で入力してください',
            'image.sometimes' => '画像は必須です',
            'image.image' => '画像形式のファイルを選択してください',
            'image.mimes' => '画像はjpeg,png,jpg,gifのみ入力してください',
            'image.max' => '画像は2048MB以内で入力してください',
        ];
    }
}
