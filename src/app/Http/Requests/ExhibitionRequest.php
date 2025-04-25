<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みユーザーならOK
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'brand' => ['nullable'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'mimes:jpeg,png,jpg'],
            'condition_id' => ['required', 'exists:conditions,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '商品説明は255文字以内で入力してください。',
            'image.required' => '商品画像をアップロードしてください。',
            'image.mimes' => '画像はjpegまたはpng形式のみです。',
            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.exists' => '選択された商品の状態が正しくありません。',
            'categories.required' => 'カテゴリを1つ以上選択してください。',
            'categories.*.exists' => '選択されたカテゴリが正しくありません。',
            'price.required' => '価格を入力してください。',
            'price.integer' => '価格は数値で入力してください。',
            'price.min' => '価格は0円以上で入力してください。',
        ];
    }
}
