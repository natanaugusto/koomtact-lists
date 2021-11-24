<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FileImport extends Model
{
    use HasFactory;

    public function save(array $options = [])
    {
        $this->hash = Str::uuid();
        return parent::save($options);
    }
}
