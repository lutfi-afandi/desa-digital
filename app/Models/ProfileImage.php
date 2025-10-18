<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileImage extends Model
{
    use HasFactory, SoftDeletes, UUID;
    protected $fillable = [
        'profile_id',
        'image'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
