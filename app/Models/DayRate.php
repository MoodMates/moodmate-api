<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DayRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate',
        'date',
        'user_id',
    ];

    /**
     * Relation avec l'utilisateur (user).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
