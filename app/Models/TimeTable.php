<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
