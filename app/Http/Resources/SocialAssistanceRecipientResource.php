<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceRecipientResource extends JsonResource
{
    // 'social_assistance_id',
    //     'head_of_family_id',
    //     'amount',
    //     'reason',
    //     'bank',
    //     'account_number',
    //     'proof',
    //     'status',
    public function toArray(Request $request): array
    {
        return [
            'social_assistance' => new SocialAssistanceResource($this->socialAssistance),
            'head_of_family' => new HeadOfFamilyResource($this->headOfFamily),
            'amount' => $request->amount,
            'reason' => $request->reason,
            'bank' => $request->reason,
            'account_number' => $request->reason,
            'proof' => $request->reason,
            'status' => $request->reason,
        ];
    }
}
