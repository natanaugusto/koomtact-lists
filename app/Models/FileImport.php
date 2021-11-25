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
 * @property $from_to
 * @see FileImport::setFromToAttribute()
 */
class FileImport extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->hash = Str::uuid();
        return parent::save($options);
    }

    /**
     * @param array $value
     */
    public function setFromToAttribute(array $value): void
    {
        $this->attributes['from_to'] = json_encode($value);
    }

    /**
     * @param Builder $query
     * @param string $hash
     * @param User $user
     * @return Builder
     */
    public function scopeByHashUser(Builder $query, string $hash, User $user): Builder
    {
        return $query->where('hash', $hash)
            ->where('user_id', $user->id);
    }
}
