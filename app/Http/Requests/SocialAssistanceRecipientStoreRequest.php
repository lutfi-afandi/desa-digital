<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceRecipientStoreRequest extends FormRequest
{
    public function rules(): array
    {

        // 'social_assistance_id',
        // 'head_of_family_id',
        // 'amount',
        // 'reason',
        // 'bank',
        // 'account_number',
        // 'proof',
        // 'status',
        return [
            'social_assistance_id' => 'required|exists:social_assistances,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'amount' => 'required|integer',
            'reason' => 'required|string',
            'bank' => 'required|string|in:bri,bni,bca,mandiri',
            'account_number' => 'required|string',
            'proof' => 'nullable|image',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ];
    }

    public function attributes()
    {
        return [
            'social_assistance_id' => 'Bantuan Sosial',
            'head_of_family_id' => 'Kepala Keluarga',
            'amount' => 'Nominal',
            'reason' => 'Alasan',
            'bank' => 'Bank',
            'account_number' => 'Nomor Rekening',
            'proof' => 'Bukti Penerimaan',
            'status' => 'Status Pengajuan',
        ];
    }
}
