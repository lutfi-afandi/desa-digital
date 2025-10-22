<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
{

    public function rules(): array
    {
        //  'thumbnail',
        // 'name',
        // 'about',
        // 'headman',
        // 'people',
        // 'agricultural_area',
        // 'total_area',
        return [
            'thumbnail' => 'required|image',
            'name' => 'required|string',
            'about' => 'required|string',
            'headman' => 'required|string',
            'people' => 'required|integer',
            'agricultural_area' => 'required|numeric',
            'total_area' => 'required|numeric',
            'images' => 'nullable|array',
            'images.*' => 'required|image|mimes:png,jpg',
            //
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'thumbnail',
            'name' => 'Nama',
            'about' => 'Deskripsi',
            'headman' => 'Kepala Desa',
            'people' => 'Jumlah Penduduk',
            'agricultural_area' => 'Luas Pertanian',
            'total_area' => 'Luas Wilayah',
            'images' => 'Gambar Pendukung',
        ];
    }
}
