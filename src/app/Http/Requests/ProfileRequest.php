<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_image' => ['nullable', 'mimes:jpeg,png'],
            'nickname' => ['required'],
            'zipcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required'],
            'building' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.mimes' => 'プロフィール画像はjpegまたはpng形式でアップロードしてください。',
            'nickname.required' => 'お名前を入力してください',
            'zipcode.required' => '郵便番号を入力してください',
            'zipcode.regex' => '郵便番号は「123-4567」の形式で入力してください',
            'address.required' => '住所を入力してください',
            'building.required' => '建物名を入力してください',
        ];
    }
}
