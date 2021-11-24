<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @method static byHashUser(string $hash, User $user): Builder
 * @see FileImport::scopeByHashUser()
 */
class FileImport extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function save(array $options = [])
    {
        $this->hash = Str::uuid();
        return parent::save($options);
    }

    public function scopeByHashUser(Builder $query, string $hash, User $user): Builder
    {
        return $query->where('hash', $hash)
            ->where('user_id', $user->id);
    }
}
