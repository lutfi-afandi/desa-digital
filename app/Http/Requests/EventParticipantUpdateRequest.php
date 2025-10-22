<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        // 'event_id',
        // 'head_od_family_id',
        // 'quantity', 
        return [
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'quantity' => 'nullable|integer',
            'payment_status' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Kepala Keluarga',
            'quantity' => 'Jumlah Peserta',
            'payment_status' => 'Status Pembayaran',
        ];
    }
}
