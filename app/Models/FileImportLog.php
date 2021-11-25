<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $log
 * @see FileImportLog::setLogAttribute()
 */
class FileImportLog extends Model
{
    /**
     * @param ?array $value
     */
    public function setLogAttribute(?array $value = null): void
    {
        if (is_array($value)) {
            $this->attributes['log'] = json_encode($value);
        }
    }
}
