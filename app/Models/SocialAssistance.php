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

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssistanceRecepient::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('amount', 'like', '%' . $search . '%')
            ->orWhere('provider', 'like', '%' . $search . '%');
    }
}
