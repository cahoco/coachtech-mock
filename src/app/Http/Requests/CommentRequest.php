<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'max:255'],
            'item_id' => ['required', 'exists:items,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'コメントを入力してください。',
            'content.max' => 'コメントは255文字以内で入力してください。',
            'item_id.required' => '商品情報が存在しません',
            'item_id.exists' => '選択された商品が存在しません',
        ];
    }
}
