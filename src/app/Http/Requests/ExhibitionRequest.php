<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みユーザーならOK
    }

    // app/Http/Requests/ExhibitionRequest.php

    public function rules()
    {
        return [
            'name'         => ['required', 'string'],
            'brand'        => ['nullable', 'string'],
            'description'  => ['required', 'string', 'max:255'],
            'image'        => ['required', 'image', 'mimes:jpeg,png,jpg'],
            'condition_id' => ['required', 'exists:conditions,id'],

            // テスト・単一選択用
            'category_id'  => ['required_without:categories', 'exists:categories,id'],

            // UI・複数選択用
            'categories'   => ['required_without:category_id', 'array'],
            'categories.*' => ['exists:categories,id'],

            'price'        => ['required', 'integer', 'min:0'],
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
