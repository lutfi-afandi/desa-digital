<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use HasFactory, SoftDeletes, UUID;
    protected $fillable =
    [
        'name',
        'category',
        'thumbnail',
        'amount',
        'provider',
        'description',
        'is_available',

    ];

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssistanceRecepient::class);
    }
}
