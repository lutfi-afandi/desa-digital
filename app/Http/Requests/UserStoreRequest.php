<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|',

        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'E-Mail',
            'password' => 'Kata sandi',
        ];
    }

    public function messages()
    {
        return [
            'string' => ':attribute harus String',
            'required' => ':attribute harus diisi',
            'max' => ':attribute maksimal :max karakter',
            'min' => ':attribute Minimal :min karakter',
            'unique' => ':attribute sudah ada',
            'email' => ':attribute harus berupa email',
        ];
    }
}
