<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diary extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
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
