<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'thumbnail' => 'required|image|mimes:png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:staple,cash,subsidized fuel,health',
            'amount' => 'required|numeric',
            'provider' => 'required|string',
            'description' => 'required|string',
            'is_available' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Nama',
            'category' => 'Kategori',
            'amount' => 'Jumlah Bantuan',
            'provider' => 'Penyedia',
            'description' => 'Deskripsi',
            'is_available' => 'Ketersediaan',

        ];
    }
}
