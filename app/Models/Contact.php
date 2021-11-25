<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 * @see Contact::user()
 */
class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'birthday',
        'credit_card',
        'email',
        'franchise',
        'name',
        'telephone',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
