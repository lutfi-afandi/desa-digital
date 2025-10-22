<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required',
            'is_active' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'thumbnail',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'price' => 'Harga',
            'date' => 'Tanggal',
            'time' => 'waktu',
            'is_active' => 'Aktif',
        ];
    }
}
