<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => 'required|max:400',
            'img_url' => 'image|mimes:jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'text.required' => '本文を入力してください',
            'img_url' => '「.png」または「.jpeg」形式でアップロードしてください',
            'text.max' => '本文は400文字以内で入力してください',
        ];
    }
}
