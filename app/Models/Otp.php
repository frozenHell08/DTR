<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_email',
        'otp'
    ];

    public $timestamps = true;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_email', 'email');
    }
}
