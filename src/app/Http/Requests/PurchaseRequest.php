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
            'payment_method' => 'required|string',
            'address_id' => 'required|integer|exists:profiles,id', // プロフィールIDとして想定
        ];
    }

    /**
     * エラーメッセージ定義
     */
    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'address_id.required' => '配送先情報が不正です。',
            'address_id.exists' => '指定された配送先が存在しません。',
        ];
    }
}
