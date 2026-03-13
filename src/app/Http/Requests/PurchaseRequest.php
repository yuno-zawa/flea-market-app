<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize()
    {
        // ログイン必須なら true
        return true;
    }

    public function rules()
    {
        return [
            'payment_method' => 'required|string',
            'address_id'     => 'required|integer|exists:addresses,id',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'address_id.required'     => '配送先を選択してください',
            'address_id.exists'       => '選択した配送先は存在しません',
        ];
    }
}
