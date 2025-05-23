<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * 購入リクエストを誰でも使えるように許可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'payment_method' => ['required'],
            'address_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'address_id.required' => '配送先情報を選択してください。',
        ];
    }
}
