<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'password'        => 'required|string|min:8',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'identity_number' => 'required|integer',
            'gender'          => 'required|string|in:male,female',
            'date_of_birth'   => 'required|date',
            'phone_number'    => 'required|string',
            'occupation'      => 'required|string',
            'marital_status'  => 'required|string|in:married,single',
        ];
    }

    public function attributes()
    {
        return [
            'name'            => 'Nama',
            'email'           => 'Email',
            'password'        => 'Kata Sandi',
            'profile_picture' => 'Foto Profil',
            'identity_number' => 'Nomor Identitas',
            'gender'          => 'Jenis Kelamin',
            'phone_number'    => 'Nomor Telepon',
            'occupation'      => 'Pekerjaan',
            'marital_status'  => 'Status Perkawinan',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'required'     => ':attribute harus diisi.',
    //         'string'       => ':attribute harus berupa string.',
    //         'max'          => ':attribute maksimal :max karakter.',
    //         'unique'       => ':attribute sudah ada.',
    //         'image'        => ':attribute harus berupa gambar.',
    //         'email'        => ':attribute harus berupa email.',
    //         'min'          => ':attribute minimal :min karakter.',
    //         'exists'       => ':attribute tidak ditemukan.',
    //         'integer'      => ':attribute harus berupa angka.',
    //         'array'        => ':attribute harus berupa array.',
    //         'mimes'        => ':attribute harus berupa gambar.',
    //         'max:2048'     => ':attribute maksimal 2048 KB.',
    //         'unique:users' => ':attribute sudah ada.',
    //         'in'           => ':attribute harus antara :values.',
    //     ];
    // }
}
