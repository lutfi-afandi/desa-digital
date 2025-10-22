<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevelopmenApplicantStoreRequest extends FormRequest
{

    public function rules(): array
    {
        //  'development_id',
        // 'user_id',
        // 'status',
        return [
            'development_id' => 'required|uuid|exists:developments,id',
            'user_id' => 'required|uuid|exists:users,id',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }

    public function attributes()
    {
        return [
            'development_id' => 'Pembangunan',
            'user_id' => 'Pengguna',
            'status' => 'Status',
        ];
    }
}
