<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecepient extends Model
{
    use HasFactory, SoftDeletes, UUID;
    protected $fillable = [
        'social_assistance_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'account_number',
        'proof',
        'status',
    ];

    function socialAssistance()
    {
        return $this->belongsTo(SocialAssistance::class);
    }

    function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
